<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToTicketOptionsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_options_details', function (Blueprint $table) {
            $table->softDeletes();
        });

        DB::table('ticket_options_details')
            ->join('ticket_options', 'ticket_options_details.ticket_options_id', '=', 'ticket_options.id') 
            ->whereNotNull('ticket_options.deleted_at')
            ->update(['ticket_options_details.deleted_at' => DB::raw('ticket_options.deleted_at')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_options_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
