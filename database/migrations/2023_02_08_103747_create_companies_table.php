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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('CardName', 200)->nullable();
            $table->integer('isActive')->default(1)->comment('0=Locked,1=Active');
            $table->integer('Type')->default(1)->comment('0=Demo, 1=Live');
            $table->timestamp('trial_until')->nullable();
            $table->timestamp('activated_on')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
