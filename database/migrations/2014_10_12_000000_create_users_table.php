<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();            
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('verification_code', 30)->nullable();
            $table->string('code', 30)->nullable();
            $table->string('password')->nullable();

            $table->tinyInteger('status_subscription')->default(1)->comment('подписка 1 - inactive, 2 - active');
            $table->tinyInteger('role_id')->default(1);
            //$table->unsignedBigInteger('role_id')->index();
            //$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('restrict');

            $table->string('push_token', 250)->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
