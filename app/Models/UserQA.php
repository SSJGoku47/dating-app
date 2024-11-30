<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQA extends Model
{
    protected $table = 'user_qa';
    protected $fillable = ['user_id', 'question_id', 'selected_answer'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
