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
        Schema::create('approval_rules', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->nullable();
            $table->string('ColumnName', 20)->nullable();
            $table->float('lowerValue', 20)->default(0);
            $table->float('higherValue', 20)->default(0);
            $table->tinyInteger('ruleCheckType')->default(0)->comment('0=equals, 1=Less Than,2=Greater than, 3=Between value');
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
        Schema::dropIfExists('approval_rules');
    }
};
