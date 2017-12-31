<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('property_id')->unsigned()->default(0);
            $table->integer('invoice_group_id')->unsigned();
            $table->integer('invoice_recurring_id')->unsigned()->default(0);
            $table->string('number');
            $table->text('recipient')->nullable();
            $table->decimal('net', 13, 3)->default(0);
            $table->decimal('tax', 13, 3)->default(0);
            $table->decimal('total', 13, 3)->default(0);
            $table->decimal('balance', 13, 3)->default(0);
            $table->text('terms')->nullable();
            $table->string('key');
            $table->timestamp('due_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
