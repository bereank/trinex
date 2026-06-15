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
        Schema::create('company_databases', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('db_name')->nullable();
            $table->string('attachment_path')->nullable();
            $table->json('documentHeaderFields')->nullable();
            $table->json('documentRowFields')->nullable();
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
        Schema::dropIfExists('company_databases');
    }
};
