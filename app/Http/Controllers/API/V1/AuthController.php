<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dcblogdev\MsGraph\Facades\MsGraph;
use Dcblogdev\MsGraph\Facades\MsGraphAdmin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function connect(){
        return MsGraph::connect();
    }

    public function showProfileImg($size){
        return response(MsGraph::get('me/photos/'.$size.'/\$value'))->header('Content-Type', 'image/jpeg');
    }

    public function callback(){
        $user = MsGraph::get('me');
print_r($user);

    }

    public function login(Request $request){
        $user = MsGraph::get('me');
        $contacts = MsGraph::get('me/photos');

        dd($user, $contacts);
    }


}