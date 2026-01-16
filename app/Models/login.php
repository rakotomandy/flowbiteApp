<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Login - User authentication and management model
 * 
 * This model handles:
 * - User authentication (extends Authenticatable)
 * - User profile data storage
 * - Password hashing and security
 * - Message relationships
 * - Session management
 */
class Login extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Database table name
     * 
     * Explicitly tells Laravel to use the 'logins' table
     * instead of default 'logins' table name
     */
    protected $table = 'logins';

    /**
     * Mass assignable attributes
     * 
     * These fields can be filled using Mass Assignment
     * Prevents mass assignment vulnerabilities
     * 
     * @var array - List of safe-to-fill fields
     */
    protected $fillable = [
        'name',     // User's display name
        'email',    // User's unique email address
        'password',  // User's hashed password
    ];

    /**
     * Hidden attributes for serialization
     * 
     * These fields are never included when model is converted to
     * array or JSON (like in API responses)
     * 
     * @var array - List of sensitive fields to hide
     */
    protected $hidden = [
        'password',        // Never expose password hashes
        'remember_token',  // Never expose remember tokens
    ];

    /**
     * Attribute casting
     * 
     * Automatically converts these attributes to specific data types
     * Ensures proper data handling and security
     * 
     * @return array - List of attribute casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Convert to Carbon datetime object
            'password' => 'hashed',           // Automatically hash passwords
        ];
    }

    /**
     * sentMessages - Relationship to messages sent by this user
     * 
     * Establishes a has-many relationship with Message model
     * A user can send many messages
     * Uses 'sender_id' as foreign key
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * receivedMessages - Relationship to messages received by this user
     * 
     * Establishes a has-many relationship with Message model
     * A user can receive many messages
     * Uses 'receiver_id' as foreign key
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * getConversationsWith - Get all conversations with a specific user
     * 
     * Retrieves all messages between this user and another user
     * Useful for loading chat history
     * 
     * @param int $userId - ID of other user
     * @return \Illuminate\Database\Eloquent\Collection - Collection of messages
     */
    public function getConversationsWith($userId)
    {
        return Message::where(function($query) use ($userId) {
                    $query->where('sender_id', $this->id)
                          ->where('receiver_id', $userId);
                })
                ->orWhere(function($query) use ($userId) {
                    $query->where('sender_id', $userId)
                          ->where('receiver_id', $this->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
    }

    /**
     * getUnreadMessagesCount - Count unread messages for this user
     * 
     * Counts messages where this user is receiver
     * and messages haven't been read (if you add read status later)
     * 
     * @return int - Number of unread messages
     */
    public function getUnreadMessagesCount()
    {
        return $this->receivedMessages()
                   ->where('read_at', null)
                   ->count();
    }

    /**
     * getLastMessageWith - Get last message in conversation with user
     * 
     * Useful for displaying preview in chat list
     * 
     * @param int $userId - ID of other user
     * @return Message|null - Last message or null if no messages
     */
    public function getLastMessageWith($userId)
    {
        return Message::where(function($query) use ($userId) {
                    $query->where('sender_id', $this->id)
                          ->where('receiver_id', $userId);
                })
                ->orWhere(function($query) use ($userId) {
                    $query->where('sender_id', $userId)
                          ->where('receiver_id', $this->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();
    }
}
