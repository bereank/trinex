<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_entry_drafts', function (Blueprint $table) {
            $table->id();
            $table->integer('UserSign')->nullable();
            $table->integer('client_id');
            $table->string('reference_1', 100)->nullable();
            $table->string('reference_2', 100)->nullable();
            $table->string('reference_3', 100)->nullable();
            $table->string('series', 100);
            $table->string('currency', 10);
            $table->decimal('exchange_rate', 20, 6);
            $table->date('posting_date');
            $table->string('ObjType', 20)->default('30');
            $table->string('DraftType', 20)->default('30');
            $table->string('OwnerCode', 20);
            $table->string('DocStatus', 1)->default('O');
            $table->string('DocNum', 20)->nullable();
            $table->string('DocCur', 20)->nullable();
            $table->decimal('DocRate', 20, 6)->nullable();
            $table->decimal('DocTotal', 20, 6)->nullable();
            $table->date('due_date')->nullable();
            $table->date('document_date');
            $table->text('remarks')->nullable();
            $table->json('lines');
            $table->json('attachments')->nullable();
            $table->string('WddStatus', 1)->default('W');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entry_drafts');
    }
};
