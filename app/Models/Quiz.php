<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizs';
    protected $guarded = [];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
