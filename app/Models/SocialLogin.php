<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    protected $table = 'social_logins';
    protected $fillable = [
        'user_id', 
        'provider', 
        'provider_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
