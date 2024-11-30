<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSwipe extends Model
{
    use HasFactory;

    protected $table = 'swipes';

    protected $fillable = [
        'user_id',
        'swiped_user_id',
        'action',
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
        return $this->belongsTo(User::class, 'swiped_user_id');
    }

    /**
     * Relationship: Chats related to this match.
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * Check if this match is mutual.
     */
    public function isMutual()
    {
        return $this->status === 'liked';
    }
}
