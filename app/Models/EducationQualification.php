<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationQualification extends Model
{
    use HasFactory;

    protected $table = 'education_qualifications';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relationship: Users who have this education level
     */
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class, 'education_level_id');
    }
}
