<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->tinyInteger('user_state_id')->default(1)
                ->unsigned();
            $table->foreign('user_state_id')
                ->references('id')
                ->on('user_states');


            $table->string('names',config('constant.attribute.names.max'));
            $table->string('surnames',config('constant.attribute.surnames.max'));
            $table->string('email',config('constant.attribute.email.max'))->unique()->nullable();
            $table->string('username',config('constant.attribute.username.max'))->unique();
            $table->string('profile_picture',config('constant.attribute.generated_image_name.max'))
                    ->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->string('api_token', 80)
                        ->unique()
                        ->nullable()
                        ->default(null);

            $table->rememberToken();

            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->bigInteger('deleted_by')->nullable()->unsigned();

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
        Schema::dropIfExists('users');
    }
}
