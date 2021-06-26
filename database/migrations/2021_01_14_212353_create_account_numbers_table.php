<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('business_payment_method_id');
            $table->foreign('business_payment_method_id')
                ->references('id')
                ->on('business_payment_method');

            $table->text('name');

            $table->text('name_bank');

            $table->text('account_number');

            $table->text('cci');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_numbers');
    }
}
