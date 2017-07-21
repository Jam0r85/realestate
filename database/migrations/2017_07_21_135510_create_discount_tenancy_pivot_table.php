<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTenancyPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_tenancy', function (Blueprint $table) {
            $table->integer('discount_id')->unsigned()->index();
            $table->integer('tenancy_id')->unsigned()->index();
            $table->string('for');

            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->foreign('tenancy_id')->references('id')->on('tenancies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_tenancy');
    }
}
