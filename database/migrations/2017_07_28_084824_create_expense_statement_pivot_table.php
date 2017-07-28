<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseStatementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_statement', function (Blueprint $table) {
            $table->integer('expense_id')->unsigned()->index();
            $table->integer('statement_id')->unsigned()->index();
            $table->decimal('amount', 12, 2);

            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('statement_id')->references('id')->on('statements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_statement');
    }
}
