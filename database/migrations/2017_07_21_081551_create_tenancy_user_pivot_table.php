<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenancyUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenancy_user', function (Blueprint $table) {
            $table->integer('tenancy_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();

            $table->foreign('tenancy_id')->references('id')->on('tenancies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenancy_user');
    }
}
