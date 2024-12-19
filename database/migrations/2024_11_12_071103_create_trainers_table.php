<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('city');
            $table->string('phone');
            $table->string('address');
            $table->string('national_id');
            $table->string('license_id');
            $table->date('license_end_date');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth')->nullable();
            $table->boolean('has_car')->default(false);
            $table->string('car_license_image')->nullable(); // Image for car license
            $table->text('reviews')->nullable(); // Field for reviews and feedback (can be a JSON structure)
            $table->string('national_id_front_image');
            $table->string('national_id_back_image');
            $table->string('license_front_image');
            $table->string('license_back_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainers');
    }
};