<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal_entry_drafts', function (Blueprint $table) {
            $table->string('status', 20)->default('draft');
        });
    }

    public function down(): void
    {
        Schema::table('journal_entry_drafts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
