<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('description');
            $table->decimal('price', 13, 2);
            $table->boolean('is_enabled')->default(1);
            $table->unsignedInteger('account_id')->index();

            $table->integer('ticket_id')->unsigned()->index();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

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
        Schema::dropIfExists('ticket_options');
    }
}
