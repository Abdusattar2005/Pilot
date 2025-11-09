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
        Schema::create('advertisements', function (Blueprint $table) {
    $table->id();
    $table->string('title')->nullable();                // аталышы
    $table->string('banner')->nullable();               // баннер сүрөтү (бир тил, анткени колдонмо англисче)
    $table->string('link')->nullable();                 // шилтеме
    $table->text('description')->nullable();            // сүрөттөмө
    $table->tinyInteger('status')->default(1);          // активдүү же жокпу
    $table->decimal('price', 10, 2)->default(0);        // баасы
    $table->date('start_date')->nullable();             // башталышы (кол менен)
    $table->date('end_date')->nullable();               // аякташы (кол менен)
    $table->timestamps();                               // created_at, updated_at авто
});

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
};
