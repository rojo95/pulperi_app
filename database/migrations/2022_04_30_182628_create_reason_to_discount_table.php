<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReasonToDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reason_to_discount', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('to_discount_id');
            $table->foreign('to_discount_id')->references('id')->on('to_discounts')->onUpdate('cascade');

            $table->text('reason');
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
        Schema::dropIfExists('reason_to_discount');
    }
}
