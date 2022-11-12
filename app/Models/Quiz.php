<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $primaryKey = 'quiz_id';
    public $incrementing = false;
    protected $keyType = 'string';

    //protected $fillable = ['question', 'optionA', 'optionB', 'optionC', ]
    protected $guarded = [];
}
