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
        Schema::create('approval_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('wdd_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('db_name')->nullable();
            $table->string('Status', 1)->nullable(); //N=Rejected, W=Pending, Y=Approved
            $table->string('OtherInfo')->nullable();
            $table->timestamp('approved_on')->nullable();
            $table->timestamp('sync_on')->nullable();
            $table->string('Remarks', 254)->nullable();
            $table->integer('SyncStatus')->default(0)->comment('0=Pending,1=Synced,2=Sync With errors');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('approval_logs');
    }
};
