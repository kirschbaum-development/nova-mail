<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovaSentMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nova_sent_mails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mail_template_id')->nullable();
            $table->morphs('mailable');
            $table->unsignedBigInteger('sender_id');
            $table->string('subject');
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('nova_sent_mails');
    }
}
