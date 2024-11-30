<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCharacteristic extends Model
{
    protected $table = 'user_characteristics';

    protected $fillable = ['user_id', 'user_characteristics_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class, 'user_characteristics_id');
    }
}
