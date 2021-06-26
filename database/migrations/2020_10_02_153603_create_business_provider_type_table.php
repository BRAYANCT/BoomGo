<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessProviderTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_provider_type', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedTinyInteger('provider_type_id');
            $table->foreign('provider_type_id')
                ->references('id')
                ->on('provider_types');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses');

            $table->unique(['provider_type_id','business_id']);

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
        Schema::dropIfExists('business_provider_type');
    }
}
