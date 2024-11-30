<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use SoftDeletes,  HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User Profile
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);  
    }

    // User Photos
  
    public function userPhotos()
    {
        return $this->hasMany(UserPhoto::class);
    }

    // User Hobbies
    public function userHobbies()
    {
        return $this->hasMany(UserHobby::class);
    }

    // User Goals
    public function userGoals()
    {
        return $this->hasMany(UserGoal::class);
    }

    // User Characteristic

    public function userCharacteristics()
    {
        return $this->hasMany(UserCharacteristic::class);
    }

    
    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'user_goals', 'user_id', 'goal_id');
    }
    

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'user_hobbies', 'user_id', 'hobby_id');
    }
    

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'user_characteristics', 'user_id', 'user_characteristics_id');
    }


    // User QA
    public function userQA()
    {
        return $this->hasMany(UserQA::class, 'user_id');
    }

    // User matches
    public function matches()
    {
        return $this->hasMany(UserMatch::class, 'user_id');
    }

    // Marched Profile
    public function matchedProfiles()
    {
        return $this->hasMany(UserMatch::class, 'matched_user_id');
    }

    // User chats
    public function userChats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function userVerify()
    {
        return $this->hasOne(UserVerify::class)->latestOfMany();
    }
    
}
