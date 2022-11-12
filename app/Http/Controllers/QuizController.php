<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'questioneng' => 'required',
            'optionAeng' => 'required',
            'optionBeng' => 'required',
            'optionCeng' => 'required',
            'optionDeng' => 'required',
            'questionhindi' => 'required',
            'optionAhindi' => 'required',
            'optionBhindi' => 'required',
            'optionChindi' => 'required',
            'optionDhindi' => 'required',
            'questionmal' => 'required',
            'optionAmal' => 'required',
            'optionBmal' => 'required',
            'optionCmal' => 'required',
            'optionDmal' => 'required',
            'answer' => 'required',
        ]);

        $quiz = Quiz::create([
            'questioneng' => $validateData['questioneng'],
            'optionAeng' => $validateData['optionAeng'],
            'optionBeng' => $validateData['optionBeng'],
            'optionCeng' => $validateData['optionCeng'],
            'optionDeng' => $validateData['optionDeng'],
            'questionhindi' => $validateData['questionhindi'],
            'optionAhindi' => $validateData['optionAhindi'],
            'optionBhindi' => $validateData['optionBhindi'],
            'optionChindi' => $validateData['optionChindi'],
            'optionDhindi' => $validateData['optionDhindi'],
            'questionmal' => $validateData['questionmal'],
            'optionAmal' => $validateData['optionAmal'],
            'optionBmal' => $validateData['optionBmal'],
            'optionCmal' => $validateData['optionCmal'],
            'optionDmal' => $validateData['optionDmal'],
            'answer' => $validateData['answer']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Quiz created successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $quiz = Quiz::all();

        return response([
            'status' => 'success',
            'quizes' => $quiz
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz, $id)
    {
        $quiz = $quiz::where('quiz_id', $id)->get();

        return response([
            'status' => 'success',
            'quiz' => $quiz
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Quiz $quiz)
    {
        $quiz::where('quiz_id', $id)->update($request->all());

        return response([
            'status' => 'success',
            'message' => 'updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
