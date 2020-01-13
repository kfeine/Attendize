<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRgpdConsentToAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendees', function (Blueprint $table) {
            if (!Schema::hasColumn('attendees','consent_privacy')) {
                $table->boolean('consent_privacy')->default(false);
            }
            if (!Schema::hasColumn('attendees','consent_share_coordinates')) {
                $table->boolean('consent_share_coordinates')->default(false);
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
            if (Schema::hasColumn('attendees','consent_privacy')) {
                $table->dropColumn('consent_privacy');
            }
            if (Schema::hasColumn('attendees','consent_share_coordinates')) {
                $table->dropColumn('consent_share_coordinates');
            }
        });
    }
}
