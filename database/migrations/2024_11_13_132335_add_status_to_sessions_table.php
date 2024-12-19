<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('session', function (Blueprint $table) {
            // Add a 'status' column with default value
            $table->enum('status', ['pending', 'accepted', 'completed', 'rejected'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('session', function (Blueprint $table) {
            // Rollback the changes
            $table->dropColumn('status');
        });
    }
}
