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
        Schema::table('approval_request_line_models', function (Blueprint $table) {
            $table->integer('isNotified')->default(0)->comment('Is the approver notified,0=No,Y=Yes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_request_line_models', function (Blueprint $table) {
            $table->integer('isNotified')->default(0)->comment('Is the approver notified,0=No,Y=Yes');
        });
    }
};
