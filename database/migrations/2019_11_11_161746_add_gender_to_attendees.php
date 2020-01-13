<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderToAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('attendees','gender')) {
            Schema::table('attendees', function (Blueprint $table) {
                $table->char('gender', 1);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('attendees','gender')) {
            Schema::table('attendees', function (Blueprint $table) {
                $table->char('gender', 1);
            });
        }
    }
}
