<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('db_name')->nullable();
            $table->string('DocNum', 100)->nullable();
            $table->string('DocEntry', 100)->nullable();
            $table->string('ObjType')->nullable();
            $table->json('data')->nullable();
            $table->json('attachments')->nullable();
            $table->json('approvers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_documents');
    }
};
