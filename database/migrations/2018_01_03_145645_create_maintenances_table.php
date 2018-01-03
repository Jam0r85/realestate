<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('key');
            $table->integer('user_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->integer('tenancy_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description');
            $table->text('data')->nullable();
            $table->timestamp('completed')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
}
