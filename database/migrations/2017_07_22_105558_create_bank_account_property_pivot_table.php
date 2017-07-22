<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountPropertyPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account_property', function (Blueprint $table) {
            $table->integer('bank_account_id')->unsigned()->index();
            $table->integer('property_id')->unsigned()->index();

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_account_property');
    }
}
