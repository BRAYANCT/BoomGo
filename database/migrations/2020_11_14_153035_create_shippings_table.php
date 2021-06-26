<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses');

            $table->unsignedBigInteger('shippingable_id');
            $table->string('shippingable_type');
            $table->index(['shippingable_id', 'shippingable_type']);

            $table->unique(['shippingable_id','shippingable_type','business_id'],'shippingable_unique');

            $table->unsignedDecimal('price',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'));

            $table->unsignedBigInteger('created_by')
                ->nullable();
            $table->unsignedBigInteger('updated_by')
                ->nullable();

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
        Schema::dropIfExists('shippings');
    }
}
