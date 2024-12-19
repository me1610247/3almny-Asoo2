<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->after('email')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('phone_verify_code')->nullable();
            $table->tinyInteger('phone_attempts_left')->default(0);
            $table->timestamp('phone_last_attempt_date')->nullable();
            $table->timestamp('phone_verify_code_sent_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
