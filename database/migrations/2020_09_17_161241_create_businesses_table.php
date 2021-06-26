<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unsignedBigInteger('category_id')
                ->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('SET NULL');

            $table->unsignedTinyInteger('price_range_id')
                ->nullable();
            $table->foreign('price_range_id')
                ->references('id')
                ->on('price_ranges');

            $table->unsignedBigInteger('district_id')
                ->nullable();
            $table->foreign('district_id')
                ->references('id')
                ->on('districts');

            $table->string('name',config('constant.attribute.company_name.max'));

            $table->string('slug',config('constant.attribute.slug.max'))->unique();

            $table->string('email',config('constant.attribute.email.max'))->nullable();

            $table->string('phone',config('constant.attribute.phone.max'))->nullable();

            $table->string('logo',config('constant.attribute.generated_image_name.max'))
                ->unique()
                ->nullable();


            $table->string('address',config('constant.attribute.address.max'))->nullable();
            $table->float('latitude',null,null)->nullable();
            $table->float('longitude',null,null)->nullable();

            $table->text('description')->nullable();


            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
