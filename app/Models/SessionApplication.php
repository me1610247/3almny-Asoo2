<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionApplication extends Model
{
    protected $fillable = ['user_id', 'session_id', 'status'];
    
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
