<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendDelayInMinutesColumnToNovaSentMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nova_sent_mails', function (Blueprint $table) {
            $table->integer('send_delay_in_minutes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nova_sent_mails', function (Blueprint $table) {
            $table->dropColumn('send_delay_in_minutes');
        });
    }
}
