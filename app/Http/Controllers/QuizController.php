<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\UserAnswer;
use Carbon\Carbon;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'question_id' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        Quiz::create([
            'question_id'=> $validateData['question_id'],
            'from_time'=> $validateData['from_time'],
            'to_time'=> $validateData['to_time']
        ]);

        return response([
            'status' => 'Success',
            'message' => 'Data added'
        ], 200);
    }

    public function show()
    {
        $quiz = Quiz::all();

        return response([
            $quiz
        ],200);
    }

    public function edit($id)
    {
        $quiz = Quiz::find($id);

        return response([
            $quiz
        ],200);
    }

    public function update(Request $request, $id)
    {
        Quiz::where('id', $id)->update($request->all());

        return response([
            'status' => 'success',
            'message' => 'Data updated'
        ], 200);
    }

    public function destroy($id)
    {
        Quiz::where('id', $id)->delete();

        return response([
            'status' => 'success',
            'message' => 'Data deleted'
        ], 200);
    }

    public function todays(){
        $now = Carbon::now();
        $dateTime = Carbon::parse($now)->toDateTimeString();
        $quiz = Quiz::where('from_time', '<=',$dateTime)->where('to_time', '>', $dateTime)->with(['question'])->get();
        
        $quiz_ids=[];
        foreach($quiz as $q){
            $quiz_ids[] = $q->id;
        }
        $answered_quest = UserAnswer::whereIn('quiz_id', $quiz_ids)
                                        ->where('user_id', auth('sanctum')->user()->id)->get()->toArray();
        
        foreach($quiz as $i => $q){
            $ans_found = false;
            foreach($answered_quest as $aq){
                if($aq['quiz_id'] == $q->id){
                    $quiz[$i]->HisAnswer = $aq['answer_key'];
                    $ans_found = true;
                }
            }
            if(!$ans_found){
                $quiz[$i]->HisAnswer = "";
            }
            $q->question->makeHidden('answer_option');
        }
        return response(["data" => $quiz], 200);
    }
}
