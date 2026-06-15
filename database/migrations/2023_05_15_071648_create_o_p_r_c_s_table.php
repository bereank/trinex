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
        Schema::create('o_p_r_c_s', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('PrcCode')->nullable();
            $table->string('PrcName')->nullable();
            $table->string('DimCode')->nullable();
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
        Schema::dropIfExists('o_p_r_c_s');
    }
};
