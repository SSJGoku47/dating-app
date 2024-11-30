<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    use HasFactory;

    protected $table = 'user_matches';

    protected $fillable = [
        'user_id',
        'match_user_id',
        'status',
    ];

    /**
     * Relationship: User who initiated the match.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: User who was matched with.
     */
    public function userMatch()
    {
        return $this->belongsTo(User::class, 'match_user_id');
    }

    /**
     * Relationship: Chats related to this match.
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
