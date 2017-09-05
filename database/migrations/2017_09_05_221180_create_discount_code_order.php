<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodeOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_code_order', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('order_id')->index();
            $table->unsignedInteger('discount_code_id')->index();

            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->foreign('discount_code_id')->references('id')->on('discount_code')->onDelete('cascade');
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
