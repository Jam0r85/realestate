<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statement_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('statement_id')->unsigned();
            $table->decimal('amount', 12, 3);
            $table->string('parent_type')->nullable();
            $table->string('parent_id')->nullable();
            $table->integer('bank_account_id')->unsigned()->nullable();
            $table->timestamp('sent_at')->nullable();
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
        Schema::dropIfExists('statement_payments');
    }
}
