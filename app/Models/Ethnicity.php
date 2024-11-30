<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{
    use HasFactory;

    protected $table = 'ethnicities';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];


    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relationship: Users who belong to this ethnicity
     */
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class, 'ethnicity_id');
    }
}
