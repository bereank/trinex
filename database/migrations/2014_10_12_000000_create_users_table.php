<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('ExtUserCode')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('UserType')->default(0)->comment('0=Normal User,1=Approver, 2=Admin,3=Super Administrator');
            $table->integer('isActive')->default(1)->comment('0=Locked,1=Active');
            $table->integer('isSystemUser')->default(0)->comment('0=Non-System User,1=System User');
            $table->json('branches')->nullable();
            $table->json('modules')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
