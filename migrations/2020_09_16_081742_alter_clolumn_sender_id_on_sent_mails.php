<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClolumnSenderIdOnSentMails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nova_sent_mails', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->nullable()->change();
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
            $table->unsignedBigInteger('sender_id')->change();
        });
    }
}
