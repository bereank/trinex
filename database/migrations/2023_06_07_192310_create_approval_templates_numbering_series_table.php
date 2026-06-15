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
        Schema::create('approval_templates_numbering_series', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('series_id')->nullable();
            $table->string('Remarks', 100)->nullable();
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
        Schema::dropIfExists('approval_templates_numbering_series');
    }
};
