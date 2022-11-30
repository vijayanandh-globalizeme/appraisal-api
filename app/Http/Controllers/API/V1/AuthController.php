<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MSToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Libraries\MSGraph;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function connect(){
        $msGraph = new MSGraph;
        $authUrl = $msGraph->oauthClient->getAuthorizationUrl();
        $oauthState = $msGraph->oauthClient->getState();
        // Save client state so we can validate in callback
        MSToken::insert([
            'token' => md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . date('Y-m-d H:i')),
            'oauthState' => $oauthState,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        // Redirect to AAD signin page
        return redirect()->away($authUrl);
    }


    public function callback(Request $request){
        $msToken = MSToken::where('token', md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . date('Y-m-d H:i')))->orderBy('id', 'DESC')->first();
        $providedState = $request->query('state');

        if (!empty($msToken) && isset($providedState) ) {
           
            $msToken = $msToken->toArray();
            $expectedState = $msToken['oauthState'];
            if($expectedState == $providedState){
                // Authorization code should be in the "code" query param
                $authCode = $request->query('code');
                if (isset($authCode)) {
                    // Initialize the OAuth client
                    $msGraph = new MSGraph;

                    try {
                        $msUserMail = $msGraph->setAccessToken($authCode);
                        $user = User::where('email', $msUserMail)->first();
                        if (empty($user)) {
                            return response()->json("Page not found", 404);
                        }
                        
                        if(Auth::loginUsingId($user->id)){
                            Auth::user()->tokens->each(function($token, $key) {
                                $token->delete();
                            });
                            // Generate token for one week expire time
                            $tokenResult = $user->createToken('Personal Access Token');
                            $token = $tokenResult->token;
                            $token->expires_at = Carbon::now()->addHour(1);
                            $token->save();
                            // dd($user, $tokenResult);

                            // Update the User Avatar
                            $avatar = $msGraph->getAvatar();
                            $imageName = 'avatar.jpeg';
                            if(!Storage::exists('/app/users/'.$user->uuid)) {
                                Storage::disk('local')->makeDirectory('users/'.$user->uuid);
                            }
                            Storage::disk('local')->put('users/'.$user->uuid.'/'.$imageName, $avatar);

                            // JSON Response 
                            $data = http_build_query([
                                'access_token' => $tokenResult->accessToken,
                                'token_type' => 'Bearer',
                                'expires_at' => Carbon::parse(
                                    $tokenResult->token->expires_at
                                )->toDateTimeString()
                            ]);
                            $appURL = config('azure.ngAppUri');
                            return redirect()->away($appURL.'/#/login?'.$data);
                        }
                    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                        dd($e);
                        return response()->json("Page not found", 404);
                    }
                }
            }
        }
        return response()->json("Page not found", 404);
    }

    public function getUserData(){
        $user = auth()->user();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->slug,
            'uuid' => $user->uuid,
        ]);
    }

    public function userPics($id){
        $fileName = 'users/'.$id.'/avatar.jpeg';
        if(Storage::exists($fileName)){
            $avatar = Storage::disk('local')->get($fileName);
        }else{
            $avatar = Storage::disk('local')->get('users/avatar.jpeg');
        }
        return response($avatar)->header('Content-Type', 'image/jpeg');
    }

}