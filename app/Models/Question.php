<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = [
        'title', 
        'option_1', 
        'option_2', 
        'option_3', 
        'option_4'
    ];


    protected $hidden = ['created_at', 'updated_at'];

    // Define any relationships if necessary
}
