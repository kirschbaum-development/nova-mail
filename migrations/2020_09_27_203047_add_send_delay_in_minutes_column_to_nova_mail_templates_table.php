<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendDelayInMinutesColumnToNovaMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nova_mail_templates', function (Blueprint $table) {
            $table->integer('send_delay_in_minutes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nova_mail_templates', function (Blueprint $table) {
            $table->dropColumn('send_delay_in_minutes');
        });
    }
}
