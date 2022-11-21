<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UserAnswerController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'quiz_id' => 'required',
            'answer_key' => ['required']
        ]);

        $now = Carbon::now();
        $dateTime = Carbon::parse($now)->toDateTimeString();
        $quiz = Quiz::where('from_time', '<=',$dateTime)->where('to_time', '>', $dateTime)->pluck('id')->toArray();
        $answered_quest = UserAnswer::whereIn('quiz_id', $quiz)
                                    ->where('user_id', auth('sanctum')->user()->id)->pluck('quiz_id')->toArray();

        //Check is quiz time is correct
        $check_presence = false;
        foreach($quiz as $k => $v){
            if($v == $validateData['quiz_id']){
                $check_presence = true;
                break;
            }
        }
        if(!$check_presence){
            return response([
                'status'=> 'Failed',
                'message'=> 'Quiz time out!'
            ],200);
        }

        //Check is already answered
        foreach($answered_quest as $k => $v){
            if($v == $validateData['quiz_id']){
                return response([
                    'status'=> 'Failed',
                    'message'=> 'Already answered question!'
                ],200);
            }
        }

        $QuizAnswer = UserAnswer::create([
            'quiz_id' => $validateData['quiz_id'],
            'user_id' => auth('sanctum')->user()->id,
            'answer_key' => $validateData['answer_key'],
        ]);

        return response([
            'status'=> 'Success',
            'message'=> 'Data added'
        ],200);
    }

    public function allAnsweres(Request $request){
        //Current questions
        $now = Carbon::now();
        $dateTime = Carbon::parse($now)->toDateTimeString();
        $UserAnswer = UserAnswer::where('user_id', auth('sanctum')->user()->id)->with('quiz', function($query) use ($dateTime) {
            $query->where('to_time', '<', $dateTime)->with(['question'])->get();
        })->get()->toArray();

        $result = [];
        foreach($UserAnswer as $ua){
            if($ua['quiz'] != NULL){
                $result[] = $ua;
            }
        }
        
        return response([
            'status'=> 'Success',
            'data'=> $result 
        ],200);
    }

    public function show(UserAnswer $userAnswer)
    {
        //
    }

    public function edit(UserAnswer $userAnswer)
    {
        //
    }
}
