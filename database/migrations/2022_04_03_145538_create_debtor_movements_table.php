<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtor_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debt_id');
            $table->foreign('debt_id')->references('id')->on('debts')->onUpdate('cascade');
            $table->boolean('movement_type');
            $table->decimal('amount_bs',10,2);
            $table->decimal('amount_usd',10,2);
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
        Schema::dropIfExists('debtor_movements');
    }
}
