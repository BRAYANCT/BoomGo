<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedTinyInteger('document_type_id');
            $table->foreign('document_type_id')
                ->references('id')
                ->on('document_types');

            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')
                ->references('id')
                ->on('districts');

            $table->string('names',config('constant.attribute.names.max'));
            $table->string('surnames',config('constant.attribute.surnames.max'));

            $table->string('identification_document',config('constant.attribute.identification_document.max'));

            $table->string('phone',config('constant.attribute.phone.max'))
                ->nullable();

            $table->string('email',config('constant.attribute.email.max'));

            $table->string('address',config('constant.attribute.address.max'));

            $table->string('tutor_full_name',config('constant.attribute.full_name.max'))
                ->nullable();

            $table->string('tutor_email',config('constant.attribute.email.max'))
                ->nullable();

            $table->unsignedTinyInteger('tutor_document_type_id')
                ->nullable();
            $table->foreign('tutor_document_type_id')
                ->references('id')
                ->on('document_types');

            $table->string('tutor_identification_document',config('constant.attribute.identification_document.max'))
                ->nullable();


            $table->enum('claim_type', ['Reclamo', 'Queja']);

            $table->enum('related_claim', ['Producto', 'Servicio']);

            $table->text('detail_claims');

            $table->text('client_request');


            $table->unsignedDecimal('amount',config('constant.attribute.float.integer_digits'),config('constant.attribute.float.decimal_digits'))
                ->nullable();


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
        Schema::dropIfExists('claims');
    }
}
