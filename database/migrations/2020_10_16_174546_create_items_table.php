<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('itemable_id');
            $table->string('itemable_type');
            $table->index(['itemable_id', 'itemable_type']);

            $table->unique(['itemable_id','itemable_type','product_id'],'itemable_unique');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');


            $table->string('name',config('constant.attribute.name.max'))
                ->index();
            $table->unsignedDecimal('price',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'))
                ->unsigned();

            $table->unsignedDecimal('offer_price',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'))
                ->nullable();

            $table->unsignedInteger('quantity');

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
        Schema::dropIfExists('items');
    }
}
