<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFM100STable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_m100_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Position')->comment("0=Header,1=RowFields");
            $table->integer('Type');
            $table->integer('UserSign')->references('id')->on('users')->nullable();
            $table->integer('ObjType');
            $table->string('Column');
            $table->string('Label');
            $table->integer('Visible');
            $table->integer('Size')->default(0);
            $table->integer('SortID');
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
        Schema::dropIfExists('f_m100_s');
    }
}
