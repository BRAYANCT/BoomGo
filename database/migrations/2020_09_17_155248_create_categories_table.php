<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedTinyInteger('category_type_id');
            $table->foreign('category_type_id')->references('id')
                ->on('category_types');

            $table->unsignedBigInteger('parent_id')
                ->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');

            $table->string('name',config('constant.attribute.company_name.max'));

            $table->string('slug',config('constant.attribute.slug.max'));

            $table->unsignedTinyInteger('level')
                ->default(1);

            $table->unsignedBigInteger('code')
                ->nullable();

            $table->string('picture',config('constant.attribute.generated_image_name.max'))
                ->unique()
                ->nullable();

            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();

            $table->unique(['category_type_id','name']);
            $table->unique(['category_type_id','slug']);

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
        Schema::dropIfExists('categories');
    }
}
