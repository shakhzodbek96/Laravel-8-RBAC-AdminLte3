<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table -> integer('client_id') -> nullable();
            $table -> string('card_number') -> nullable();
            $table -> string('expire') -> nullable();
            $table -> string('owner') -> nullable();
            $table -> string('phone') -> nullable();
            $table -> string('sms') -> nullable();
            $table -> integer('status') -> nullable();
            $table -> integer('type') -> nullable();
            $table -> string('acct') -> nullable();
            $table -> integer('acct_type') -> nullable();
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
        Schema::dropIfExists('cards');
    }
}
