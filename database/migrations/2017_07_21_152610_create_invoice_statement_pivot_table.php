<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceStatementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_statement', function (Blueprint $table) {
            $table->integer('invoice_id')->unsigned()->index();
            $table->integer('statement_id')->unsigned()->index();

            $table->foreign('invoice_id')->references('id')->on('invoices');
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
        Schema::dropIfExists('invoice_statement');
    }
}
