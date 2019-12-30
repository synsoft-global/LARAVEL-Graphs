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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
			$table->string('profile_image')->nullable();
            $table->unsignedBigInteger('user_role_id');
            $table->string('password');
            $table->string('phone');
			$table->string('users_categories');
            $table->timestamp('email_verified_at')->nullable();           
            $table->rememberToken();
            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->onDelete('cascade');
            $table->timestamps();  

            $table->index('first_name');
            $table->index('last_name');
            $table->index('email');

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
