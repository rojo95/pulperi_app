<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotToDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lot_to_discount', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('to_discount_id');
            $table->foreign('to_discount_id')->references('id')->on('to_discounts')->onUpdate('cascade');
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')->on('lots')->onUpdate('cascade');

            $table->decimal('quantity',10,2);
            $table->decimal('price_bs',10,2);
            $table->decimal('price_usd',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lot_to_discount');
    }
}
