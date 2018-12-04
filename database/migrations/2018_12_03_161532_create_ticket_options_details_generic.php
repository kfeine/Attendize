<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketOptionsDetailsGeneric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_options_details_generics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('title');
            $table->integer('quantity_available')->nullable()->default(null);
            $table->integer('quantity_sold')->default(0);
            $table->nullableTimestamps();
        });

        /**
         * The ticket options details.
         */
        Schema::table('ticket_options_details', function (Blueprint $table)
        {
            $table->unsignedInteger('ticket_options_details_generic_id')->nullable();
            $table->foreign('ticket_options_details_generic_id')->references('id')->on('ticket_options_details_generics');
        });

        Schema::create('reserved_options_generics', function ($table) {
            $table->increments('id');
            $table->integer('ticket_options_details_generic_id');
            $table->integer('quantity_reserved');
            $table->datetime('expires');
            $table->string('session_id', 45);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('ticket_options_details', function (Blueprint $table) {
            $table->dropForeign('ticket_options_details_ticket_options_details_generic_id_foreign');
            $table->dropColumn('ticket_options_details_generic_id');
        });
        Schema::dropIfExists('ticket_options_details_generics');
        Schema::dropIfExists('reserved_options_generics');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
