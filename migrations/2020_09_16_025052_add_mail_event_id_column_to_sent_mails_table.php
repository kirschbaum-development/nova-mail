<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailEventIdColumnToSentMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nova_sent_mails', function (Blueprint $table) {
            $table->unsignedBigInteger('mail_event_id')->nullable();
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
            $table->dropColumn('mail_event_id');
        });
    }
}
