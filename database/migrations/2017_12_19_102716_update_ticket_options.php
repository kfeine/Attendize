<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTicketOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Checkbox, dropdown, radio, text etc.
         */
        Schema::create('ticket_options_types', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('alias');
            $table->string('name');
            $table->boolean('has_options')->default(false);
            $table->boolean('allow_multiple')->default(false);
        });

        /**
         * The ticket options.
         */
        Schema::table('ticket_options', function (Blueprint $table)
        {
            $table->dropColumn('description');
            $table->dropColumn('price');
            $table->dropColumn('multiple');

            $table->unsignedInteger('ticket_options_type_id');
            $table->integer('sort_order')->default(1);

            $table->tinyInteger('is_required')->default(0);

            $table->timestamps();

            $table->foreign('ticket_options_type_id')->references('id')->on('ticket_options_types');
        });

        /**
         * Used for the ticket options that allow details (checkbox, radio, dropdown).
         */
        Schema::create('ticket_options_details', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('description');
            $table->decimal('price', 13, 2);

            $table->integer('ticket_options_id')->unsigned()->index();

            $table->foreign('ticket_options_id')->references('id')->on('ticket_options')->onDelete('cascade');
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
        Schema::dropIfExists('ticket_options_details');
        Schema::table('ticket_options', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->text('description');
            $table->decimal('price', 13, 2);
            $table->dropForeign('ticket_options_ticket_options_type_id_foreign');
            $table->dropColumn('ticket_options_type_id');
            $table->dropColumn('sort_order');
            $table->dropColumn('is_required');
            $table->boolean('multiple')->default(False);
        });
        Schema::dropIfExists('ticket_options_types');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
