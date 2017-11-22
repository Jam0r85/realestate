<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementPaymentUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statement_payment_user', function (Blueprint $table) {
            $table->integer('statement_payment_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();

            $table->foreign('statement_payment_id')->references('id')->on('statement_payments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDeleyte('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statement_payment_user');
    }
}
