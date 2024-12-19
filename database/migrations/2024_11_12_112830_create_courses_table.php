<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainer_id');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 8, 2)->nullable(); // Optional price field
            $table->boolean('approved')->default(false); // Approval status
            $table->timestamps();

            // Foreign key constraint to trainers table
            $table->foreign('trainer_id')->references('id')->on('trainers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
