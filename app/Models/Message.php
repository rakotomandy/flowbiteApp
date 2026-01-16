<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Message - Represents a chat message between users
 * 
 * This model handles:
 * - Message storage and retrieval
 * - Relationships between users
 * - Mass assignment protection
 * - Database table mapping
 */
class Message extends Model
{
    use HasFactory;

    /**
     * Database table name
     * 
     * Explicitly tells Laravel to use the 'messages' table
     * instead of the default 'messages' (which would be the same anyway)
     */
    protected $table = 'messages';

    /**
     * Mass assignable attributes
     * 
     * These fields can be filled using Mass Assignment
     * This prevents mass assignment vulnerabilities
     * 
     * @var array - List of safe-to-fill fields
     */
    protected $fillable = [
        'sender_id',    // ID of user who sent the message
        'receiver_id',   // ID of user who received the message
        'message',      // The actual message content
    ];

    /**
     * sender - Relationship to the user who sent the message
     * 
     * Establishes a belongs-to relationship with the Login model
     * A message belongs to exactly one sender
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(Login::class, 'sender_id');
    }

    /**
     * receiver - Relationship to the user who received the message
     * 
     * Establishes a belongs-to relationship with the Login model
     * A message belongs to exactly one receiver
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(Login::class, 'receiver_id');
    }

    /**
     * Helper method to get formatted creation time
     * 
     * Useful for displaying human-readable timestamps
     * 
     * @return string - Formatted date/time
     */
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('h:i A');
    }

    /**
     * Helper method to check if message is from current user
     * 
     * Useful in views to determine message alignment
     * 
     * @param int $currentUserId - ID of currently authenticated user
     * @return bool - True if current user sent this message
     */
    public function isFromCurrentUser($currentUserId)
    {
        return $this->sender_id == $currentUserId;
    }
}
