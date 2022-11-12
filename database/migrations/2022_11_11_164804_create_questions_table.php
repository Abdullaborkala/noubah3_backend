<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_eng');
            $table->string('question_hindi');
            $table->string('question_mal');
            $table->string('question_kan');
            $table->string('ans_eng_a');
            $table->string('ans_hindi_a');
            $table->string('ans_mal_a');
            $table->string('ans_kan_a');
            $table->string('ans_eng_b');
            $table->string('ans_hindi_b');
            $table->string('ans_mal_b');
            $table->string('ans_kan_b');
            $table->string('ans_eng_c');
            $table->string('ans_hindi_c');
            $table->string('ans_mal_c');
            $table->string('ans_kan_c');
            $table->string('ans_eng_d');
            $table->string('ans_hindi_d');
            $table->string('ans_mal_d');
            $table->string('ans_kan_d');
            $table->string('answer_option');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
