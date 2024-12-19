<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'phone', 'city', 'has_car', 'gender', 'address', 
        'date_of_birth', 'national_id', 'license_id', 'license_end_date', 
        'license_front_image', 'license_back_image', 'national_id_front_image', 
        'national_id_back_image', 'car_license_image', 'reviews',
    ];

    // Cast reviews to array so we can work with it directly
    protected $casts = [
        'reviews' => 'array', // Automatically cast reviews field to an array
    ];

    // Example method to check if a user has reviewed this trainer
    
    public function getReviewsAttribute($value)
    {
        // If the reviews column is not empty, decode it to an array, otherwise return an empty array
        return $value ? json_decode($value, true) : [];
    }
    
    public function setReviewsAttribute($value)
    {
        // Encode the reviews array as JSON before saving it to the database
        $this->attributes['reviews'] = json_encode($value);
    }
    
    public function addReview($rating, $review)
    {
        // Get the current reviews or initialize an empty array if none exist
        $reviews = $this->reviews;
    
        // Add the new review and rating to the array
        $reviews[] = [
            'rating' => $rating,
            'review' => $review,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    
        // Save the updated reviews
        $this->reviews = $reviews;
        $this->save();
    }
    public function hasUserReviewed($userId)
    {
        // Get the reviews as an array
        $reviews = $this->reviews;
    
        // Check if a review from the user already exists
        return collect($reviews)->where('user_id', $userId)->isNotEmpty();
    }    
  

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isInformationComplete()
    {
        return !empty($this->address) && 
               !empty($this->city) && 
               !empty($this->phone) && 
               !empty($this->national_id) && 
               !empty($this->date_of_birth) && 
               !empty($this->license_id) && 
               !empty($this->gender);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function sessions()
    {
        return $this->hasMany(Session::class, 'trainer_id');
    }
}
