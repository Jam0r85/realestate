<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGasSafeReminderUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gas_safe_reminder_user', function (Blueprint $table) {
            $table->integer('gas_safe_reminder_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();

            $table->foreign('gas_safe_reminder_id')->references('id')->on('gas_safe_reminders');
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
        Schema::dropIfExists('gas_safe_reminder_user');
    }
}
