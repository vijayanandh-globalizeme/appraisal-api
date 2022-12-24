<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserReview;
use App\Models\User;
use Validator;
use App\Models\ReviewQuestion;

class UserReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        $user = User::where('uuid', $id)->first();
        if($user){
            $year = date('Y');
            $data = $request->all();
            if(isset($data['year']) && $data['year'] != null){
                $year = $data['year'];
            }
            $reviews = UserReview::select('data','created_at')
                                    ->whereYear('created_at', $year)
                                    ->where('user_id', $user->id)->get();
            return response()->json([
                'data' => $reviews
            ]);
        }
        return response()->json("Something went wrong", 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationArray = [
            'review.*' => 'required|array',
            'user_id' => 'required',
        ];
        $questions = ReviewQuestion::where('status', 1)->get();
        $data = $request->all();
        foreach ($questions as $key => $value) {
            if($value->isRequired == 1){
                $validationArray['review.'.$key.'.'.$value->name] = 'required';
            }
        }
        $validator = Validator::make($data, $validationArray);
        if ($validator->fails()) return response()->json($validator->errors(), 422);
        $user = User::where('uuid', $data['user_id'])->first();
        if($user){
            $data['user_id'] = $user->id;
            $data['colleague_id'] = auth()->id();
            $data['data'] = json_encode($data['review']);
            if(UserReview::create($data)){
                return response()->json([
                    "message" => "Success"
                ]);
            }
        }
        return response()->json("Something went wrong", 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
