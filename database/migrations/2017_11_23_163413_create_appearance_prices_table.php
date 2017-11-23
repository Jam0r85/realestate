<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppearancePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appearance_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appearance_id')->unsigned();
            $table->decimal('price', 13, 3);
            $table->integer('qualifier_id')->nullable();
            $table->timestamp('start_at');
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
        Schema::dropIfExists('appearance_prices');
    }
}
