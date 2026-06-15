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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();  
            $table->integer('DocEntry')->nullable();  
            $table->string('ItemCode')->nullable();
            $table->string('ItemName')->nullable();  
            $table->string('InvntryUom')->nullable();
            $table->string('U_ProdLine');
            $table->string('U_GrpDesc');
            $table->string('Branch');
            $table->decimal('QtyInstock',20,2);
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
        Schema::dropIfExists('stocks');
    }
};
