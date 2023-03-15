<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserReview;
use App\Models\User;
use Validator;
use App\Models\ReviewQuestion;
use App\Models\ReviewQuestionCategory;
use PDF;


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
            $reviews = UserReview::select('id','data','created_at')
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
            $reviewId = UserReview::create($data)->id;
            if($reviewId){
                $this->downloadReport($reviewId, 'email');
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

    // Generate PDF
    public function downloadReport($id, $type) {
        $reviews['data'] = UserReview::with('user')->where('id', $id)->first()->toArray();
        $userData = json_decode($reviews['data']['data'], true);
        $subData = [];
        foreach ($userData as $value) {
            foreach ($value as $key => $answer) {
                $subData[$key] = $answer;
                break;
            }
            
        }
        $reviews['data']['answer'] = $subData;
        $reviews["questions"] = ReviewQuestion::select("id","name","label","category_id")
                                        ->where('status', 1)->get()->toArray();
        $reviews["category"] = ReviewQuestionCategory::get()->toArray();
        view()->share('reviews',$reviews);
        $pdf = PDF::loadView('pdf.report', $reviews);

        $data["email"] = ["vijay.anandh@globalizeme.com", "vinodh.bilavendran@globalizeme.com"];
        $data["title"] = " Review submitted for ".$reviews['data']["user"]["name"];
        if($type == 'download'){
           return $pdf->download('report.pdf'); 
        }
        if($type == 'email'){
            return \Mail::send('emails.report', $data, function($message)use($data, $pdf) {
                $message->to($data["email"])
                        ->from('no-reply@gm360.com', 'GM360 Report')
                        ->subject($data["title"])
                        ->attachData($pdf->output(), "report.pdf");
            });
        }
        return;
    }

}
