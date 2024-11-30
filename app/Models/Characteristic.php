<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    protected $table = 'characteristics';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    // Hides attributes
     protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relationship: Users who have this characteristic
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_characteristics');
    }
}
