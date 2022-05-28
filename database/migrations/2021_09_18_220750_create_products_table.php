<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',45)->unique();
            $table->string('img',45)->unique()->nullable();
            $table->string('description')->nullable();
            $table->decimal('bar_code',13,0)->unique();
            $table->decimal('unit_box',10,0)->nullable();

            $table->unsignedBigInteger('sales_measure_id');
            $table->foreign('sales_measure_id')->references('id')->on('sales_measures')->onUpdate('cascade');

            $table->unsignedBigInteger('products_type_id');
            $table->foreign('products_type_id')->references('id')->on('products_types')->onUpdate('cascade');

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
        Schema::dropIfExists('products');
    }
}
