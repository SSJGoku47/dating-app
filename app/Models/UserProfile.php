<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{   
    protected $table = 'user_profiles';
    protected $fillable = [
        'user_id',
        'gender_id',
        'match_gender_preference_id',
        'ethnicity_id',
        'education_qualifications_id',
        'religion',
        'occupation',
        'about',
        'age',
        'height',
    ];
    
    /**
     * Relationship: User that the profile belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    /**
     * Relationship: Gender of the user
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id'); 
    }

    public function matchGenderPreference()
    {
        return $this->belongsTo(Gender::class, 'match_gender_preference_id');
    }

    public function ethnicity()
    {
        return $this->belongsTo(Ethnicity::class ,'ethnicity_id');
    }


    public function educationQualification()
    {
        return $this->belongsTo(EducationQualification::class, 'education_qualifications_id');
    }
}
