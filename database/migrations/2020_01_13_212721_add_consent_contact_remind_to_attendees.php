<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsentContactRemindToAttendees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendees', function (Blueprint $table) {
            if (!Schema::hasColumn('attendees','consent_contact_reminder')) {
                $table->boolean('consent_contact_reminder')->default(false);
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
            if (Schema::hasColumn('attendees','consent_contact_reminder')) {
                $table->dropColumn('consent_contact_reminder');
            }
        });
    }
}
