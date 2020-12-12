<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBirthdateToAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendees', function (Blueprint $table) {
            if (!Schema::hasColumn('attendees','birthdate')) {
                $table->date('birthdate')->default(date("1900-01-01"));
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendees', function (Blueprint $table) {
            if (Schema::hasColumn('attendees','birthdate')) {
                $table->dropColumn('birthdate');
            }
        });
    }
}
