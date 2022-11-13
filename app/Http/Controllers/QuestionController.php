<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'question_eng' => 'required',
            'question_hindi' => 'required',
            'question_mal' => 'required',
            'question_kan' => 'required',

            'ans_eng_a' => 'required',
            'ans_hindi_a' => 'required',
            'ans_mal_a' => 'required',
            'ans_kan_a' => 'required',

            'ans_eng_b' => 'required',
            'ans_hindi_b' => 'required',
            'ans_mal_b' => 'required',
            'ans_kan_b' => 'required',

            'ans_eng_c' => 'required',
            'ans_hindi_c' => 'required',
            'ans_mal_c' => 'required',
            'ans_kan_c' => 'required',

            'ans_eng_d' => 'required',
            'ans_hindi_d' => 'required',
            'ans_mal_d' => 'required',
            'ans_kan_d' => 'required',

            'answer_option' => 'required'
        ]);

        Question::create([
            'question_eng' => $validateData['question_eng'],
            'question_hindi' => $validateData['question_hindi'],
            'question_mal' => $validateData['question_mal'],
            'question_kan' => $validateData['question_kan'],

            'ans_eng_a' => $validateData['ans_eng_a'],
            'ans_hindi_a' => $validateData['ans_hindi_a'],
            'ans_mal_a' => $validateData['ans_mal_a'],
            'ans_kan_a' => $validateData['ans_kan_a'],

            'ans_eng_b' => $validateData['ans_eng_b'],
            'ans_hindi_b' => $validateData['ans_hindi_b'],
            'ans_mal_b' => $validateData['ans_mal_b'],
            'ans_kan_b' => $validateData['ans_kan_b'],

            'ans_eng_c' => $validateData['ans_eng_c'],
            'ans_hindi_c' => $validateData['ans_hindi_c'],
            'ans_mal_c' => $validateData['ans_mal_c'],
            'ans_kan_c' => $validateData['ans_kan_c'],

            'ans_eng_d' => $validateData['ans_eng_d'],
            'ans_hindi_d' => $validateData['ans_hindi_d'],
            'ans_mal_d' => $validateData['ans_mal_d'],
            'ans_kan_d' => $validateData['ans_kan_d'],

            'answer_option' => $validateData['answer_option']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully!',
        ]);
    }

    public function show(Request $request)
    {
        $params = $request->all();
        $per_page = isset($params['per_page']) ? $params['per_page']: 10;
        $searchKey = isset($params['searchKey']) ? $params['searchKey']: '';
        if(isset($params['searchKey']) && isset($params['searchKey']) != ''){
            $question = Question::where('question_eng', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('question_eng', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('question_hindi', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('question_mal', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('question_kan', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_a', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_hindi_a', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_mal_a', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_kan_a', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_b', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_hindi_b', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_mal_b', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_kan_b', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_c', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_hindi_c', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_mal_c', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_kan_c', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_eng_d', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_hindi_d', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_mal_d', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('ans_kan_d', 'LIKE' , '%'.$searchKey.'%')
                                    ->paginate($per_page)->toArray();
        }else{
            $question = Question::paginate($per_page)->toArray();
        }
        
        if(!$question){
            return response(["message" => 'No data found!']);
        }

        return response([
            'success' => true,
            'data' => $question['data']
        ],200);
    }

    public function edit($id)
    {
        $question = Question::find($id);
        if(!$question){
            return response(["message" => 'No data found!']);
        }
        return response($question);
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        if(!$question){
            return response(["message" => 'No data found!'], 200);
        }
        
        Question::where('id', $id)->update($request->all());
        
        return response([
            "status" => "Success", 
            "message" => "Data updated"
        ], 200);
    }

    public function destroy($id)
    {
        Question::where('id', $id)->delete();

        return response([
            "status" => "Success", 
            "message" => "Data deleted"
        ], 200);
    }
}
