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
        Schema::create('approval_request_line_models', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('WddCode')->nullable();
            $table->integer('StepCode')->nullable(); //Stage Key
            $table->integer('UserID')->nullable(); //    Authorizer Code
            $table->string('Status', 1)->default('W'); //N=Rejected, W=Pending, Y=Approved
            $table->string('Remarks', 254)->nullable();
            $table->integer('UserSign')->nullable();
            $table->datetime('UpdateDate')->nullable();
            $table->datetime('UpdateTime')->nullable();
            $table->integer('SortId')->nullable();
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
        Schema::dropIfExists('approval_request_line_models');
    }
};
