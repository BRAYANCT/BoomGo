<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('names',config('constant.attribute.names.max'));
            $table->string('surnames',config('constant.attribute.surnames.max'));

            $table->string('email',config('constant.attribute.email.max'));

            $table->string('phone',config('constant.attribute.phone.max'))
                ->nullable();

            $table->string('company_name',config('constant.attribute.company_name.max'))
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
        Schema::dropIfExists('contacts');
    }
}
