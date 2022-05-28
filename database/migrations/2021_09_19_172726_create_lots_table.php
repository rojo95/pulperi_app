<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('cod_lot');
            $table->decimal('quantity',10,2);
            $table->decimal('price_bs',10,2);
            $table->decimal('price_dollar',10,2);
            $table->decimal('sell_price',10,2);

            $table->unsignedBigInteger('divisa_id');
            $table->foreign('divisa_id')->references('id')->on('divisas')->onUpdate('cascade');

            $table->decimal('sold',10,2)->default(0);
            $table->timestamp('expiration');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('lots');
    }
}
