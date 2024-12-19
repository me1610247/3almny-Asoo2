<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course'; 

    protected $fillable = [
        'trainer_id',
        'title',
        'description',
        'price',
        'approved',
    ];

    public function trainer()
{
    return $this->belongsTo(Trainer::class);
}
public function sessions()
{
    return $this->hasMany(Session::class);
}
}
