<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'useranswer';
    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
