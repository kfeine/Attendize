<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomToAttendees extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('attendees','room')) {
            Schema::table('attendees', function (Blueprint $table) {
                $table->string('room')->nullable()->default(null);
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('attendees','room')) {
            Schema::table('attendees', function (Blueprint $table) {
                $table->dropColumn('room');
            });
        }
    }
}
