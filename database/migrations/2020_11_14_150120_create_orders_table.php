<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_group_id');
            $table->foreign('order_group_id')
                ->references('id')
                ->on('order_groups');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses');

            $table->unsignedTinyInteger('order_state_id');
            $table->foreign('order_state_id')
                ->references('id')
                ->on('order_states');

//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users');
//
//            $table->unsignedBigInteger('billing_information_id');
//            $table->foreign('billing_information_id')
//                ->references('id')
//                ->on('billing_information');
//
//            $table->unsignedTinyInteger('payment_method_id');
//            $table->foreign('payment_method_id')
//                ->references('id')
//                ->on('payment_methods');

            $table->unsignedDecimal('shipping_price',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'))
            ->default(0.00);

//            $table->text('observation')
//                ->nullable();

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
        Schema::dropIfExists('orders');
    }
}
