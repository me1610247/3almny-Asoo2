<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    protected $table = 'messages'; 

    protected $fillable = ['user_id', 'trainer_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // This assumes that 'user_id' is the foreign key
    }
    
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id'); // This assumes that 'trainer_id' is the foreign key
    }
    public function getSenderAttribute()
    {
        return Auth::id() === $this->user_id ? $this->user : $this->trainer;
    }

    public function getReceiverAttribute()
    {
        return Auth::id() === $this->user_id ? $this->trainer : $this->user;
    }

    public static function conversation($userId, $trainerId)
    {
        return self::where(function ($query) use ($userId, $trainerId) {
            $query->where('user_id', $userId)->where('trainer_id', $trainerId);
        })->orWhere(function ($query) use ($userId, $trainerId) {
            $query->where('user_id', $trainerId)->where('trainer_id', $userId);
        })->orderBy('created_at', 'asc')->get();
    }
    public static function messageExists()
    {
        return self::where('user_id', auth()->id())
            ->orWhere('trainer_id', auth()->id())
            ->exists();  // Returns true if messages exist
    }
}
