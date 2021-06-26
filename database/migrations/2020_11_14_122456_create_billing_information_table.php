<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_information', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')
                ->references('id')
                ->on('districts');

            $table->string('names',config('constant.attribute.names.max'));
            $table->string('surnames',config('constant.attribute.surnames.max'));
            $table->string('email',config('constant.attribute.email.max'));
            $table->string('phone',config('constant.attribute.phone.max'))
                ->nullable();

            $table->string('address',config('constant.attribute.address.max'));


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
        Schema::dropIfExists('billing_information');
    }
}
