<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $table = 'genders';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    // Hides attributes
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relationship: Users with this gender
     */
    public function users()
    {
        return $this->hasMany(UserProfile::class, 'gender_id');
    }

    /**
     * Relationship: Users interested in this gender
     */
    public function interestedGender()
    {
        return $this->hasMany(UserProfile::class, 'preferred_gender_id');
    }
}
