<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessPaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_payment_method', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedTinyInteger('payment_method_id');
            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses');

            $table->unique(['payment_method_id','business_id']);

            $table->text('access_token')->nullable();
            $table->text('public_key')->nullable();
            $table->text('client_id')->nullable();
            $table->text('refresh_token')->nullable();
            $table->date('date_expire_token')->nullable();

            $table->text('client_secret')->nullable();

            $table->boolean('sandbox')->nullable();
            $table->text('test_access_token')->nullable();
            $table->text('test_public_key')->nullable();

            $table->text('description')->nullable();

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
        Schema::dropIfExists('business_payment_method');
    }
}
