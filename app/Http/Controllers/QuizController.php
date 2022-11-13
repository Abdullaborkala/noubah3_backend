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
            'success' => true,
            'message' => 'Data added'
        ], 200);
    }

    public function show(Request $request)
    {
        $params = $request->all();
        $per_page = isset($params['per_page']) ? $params['per_page']: 10;
        $searchKey = isset($params['searchKey']) ? $params['searchKey']: '';

        $now = Carbon::now();
        $dateTime = Carbon::parse($now)->toDateTimeString();

        $quiz = Quiz::with(['question'])
                    ->whereHas('question', function($query) use ($searchKey){
                            $query->where('question_eng', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_a', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_b', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_c', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_d', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_d', 'LIKE' , '%'.$searchKey.'%');
                    })
                    ->orwhere('from_time', 'LIKE' , '%'.$searchKey.'%')
                    ->orWhere('to_time', 'LIKE' , '%'.$searchKey.'%')
                    ->paginate($per_page)->toArray();

        if(isset($params['currentQuiz'])){
            $now = Carbon::now();
            $dateTime = Carbon::parse($now)->toDateTimeString();
            $quizToday = Quiz::where('from_time', '<=',$dateTime)->where('to_time', '>', $dateTime)->with(['question'])->pluck('id');
            
            $temp_quiz=[];
            foreach($quiz['data'] as  $i => $q){
                foreach($quizToday as $qT){
                    if($q['id'] == $qT){
                        $temp_quiz[] = $q;
                    }
                }
            }
            $quiz = $temp_quiz;
        }else{
            $quiz = $quiz['data'];
        }
        return response([
            'success' => true,
            'data' => $quiz
        ],200);
    }

    public function edit($id)
    {
        $quiz = Quiz::with(['question'])->find($id);
        if(!$quiz){
            return response(["message" => 'No data found!']);
        }
        return response($quiz);
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
