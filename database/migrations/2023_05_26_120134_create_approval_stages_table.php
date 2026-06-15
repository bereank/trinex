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
        Schema::create('approval_stages', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('Name', 200)->nullable();
            $table->string('Remarks', 100)->nullable();
            $table->tinyInteger('MaxReqr')->default(1);
            $table->tinyInteger('MaxRejReqr')->default(1);
            $table->integer('UserSign')->nullable();
            $table->integer('rule_id')->nullable();
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
        Schema::dropIfExists('approval_stages');
    }
};
