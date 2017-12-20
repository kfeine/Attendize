<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBelongstoAttendeeTicketOptionsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('attendee_ticket_options');

        Schema::create('attendee_ticket_options_details', function (Blueprint $table) {
            $table->integer('attendee_id')->unsigned()->nullable();
            $table->foreign('attendee_id')->references('id')->on('attendees')->onDelete('cascade');
            
            $table->integer('ticket_options_details_id')->unsigned()->nullable();
            $table->foreign('ticket_options_details_id')->references('id')->on('ticket_options_details')->onDelete('cascade');
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
        Schema::create('attendee_ticket_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendee_id');
            $table->integer('ticket_options_id');
            $table->timestamps();
        });
        Schema::dropIfExists('attendee_ticket_options_details');
    }
}
