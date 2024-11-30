<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $table = 'goals';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    // Hides attributes
    protected $hidden = ['created_at', 'updated_at'];
    

    /**
     * Relationship: Users who have selected this goal
     */
    public function users()
    {
        return $this->hasMany(UserProfile::class, 'goal_id');
    }

    public function userProfiles()
    {
        return $this->belongsToMany(UserProfile::class, 'user_goals', 'goal_id', 'user_id');
    }
}
