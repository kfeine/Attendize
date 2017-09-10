<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255);
            $table->string('code', 255)->unique();
            $table->decimal('price', 5, 2);
            $table->unsignedInteger('event_id')->index();
            $table->unsignedInteger('account_id')->index();
            $table->tinyInteger('is_enabled')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discounts_update', function (Blueprint $table) {
            //
        });
    }
}
