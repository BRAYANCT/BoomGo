<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses');

            $table->string('name',config('constant.attribute.name.max'));

            $table->string('slug',config('constant.attribute.slug.max'))
                ->unique();

            $table->text('short_description')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->float('price',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'))
                ->unsigned();

            $table->float('offer_price',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'))
                ->unsigned()
                ->nullable();


            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->boolean('offer_date_range')->default(0);

            $table->string('picture',config('constant.attribute.generated_image_name.max'))
                ->unique()
                ->nullable();

            $table->boolean('active')
                ->default(1);

            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->bigInteger('deleted_by')->nullable()->unsigned();

            $table->softDeletes();

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
