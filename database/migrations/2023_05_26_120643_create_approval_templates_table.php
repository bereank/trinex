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
        Schema::create('approval_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('Name', 200)->nullable();
            $table->string('Remarks', 100)->nullable();
            $table->integer('series_id')->nullable();
            $table->string('CompanyName')->nullable();
            $table->string('U_PCash')->nullable();
            $table->string('U_TypePur')->nullable();
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
        Schema::dropIfExists('approval_templates');
    }
};
