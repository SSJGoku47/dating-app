<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    protected $table = 'user_verify';

    protected $fillable = [
        'user_id',
        'otp',
        'is_used',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
