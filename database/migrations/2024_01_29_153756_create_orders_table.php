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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('company_id')->index();
            $table->foreign('company_id')->references('id')->on('info_companies')->onDelete('cascade')->onUpdate('restrict');
            
            $table->unsignedBigInteger('position_id')->index();
            $table->foreign('position_id')->references('id')->on('list_positions')->onDelete('cascade')->onUpdate('restrict');

            $table->unsignedBigInteger('contract_id')->index();
            $table->foreign('contract_id')->references('id')->on('list_contracts')->onDelete('cascade')->onUpdate('restrict');

            $table->unsignedBigInteger('plane_id')->index();
            $table->foreign('plane_id')->references('id')->on('list_planes')->onDelete('cascade')->onUpdate('restrict');

            $table->string('comment', 250)->nullable();

            $table->integer('total_flight_time')->default(0)->comment('Общее время полета Role 23');
            $table->integer('salary_min')->default(0)->comment('Заработная плата');
            $table->unsignedBigInteger('salarie_type_id')->default(1);
            $table->foreign('salarie_type_id')->references('id')->on('list_salaries')->onDelete('cascade')->onUpdate('restrict');


            $table->string('departure', 100)->nullable();
            $table->date('departure_date')->nullable();
            $table->string('arrival', 100)->nullable();
            $table->date('arrival_date')->nullable();



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
        Schema::dropIfExists('orders');
    }
};
