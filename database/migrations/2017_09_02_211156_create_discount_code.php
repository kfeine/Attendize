<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('code', 255);
            $table->decimal('price', 5, 2);
            $table->timestamp('start_sale_date');
            $table->timestamp('end_sale_date');
            $table->timestamp('created_at');
            $table->timestamp('deleted_at');
            $table->timestamp('updated_at');
            $table->integer('event_id')->unsigned()->index();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_codes_update', function (Blueprint $table) {
            //
        });
    }
}
