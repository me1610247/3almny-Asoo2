<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'session'; 

    protected $fillable = ['trainer_id', 'course_id', 'number_of_sessions', 'status'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function trainer()
{
    return $this->belongsTo(Trainer::class, 'trainer_id');
}
public function applications()
{
    return $this->hasMany(SessionApplication::class);
}
}


