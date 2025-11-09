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
         Schema::create('text_ads', function (Blueprint $table) {
             $table->id();
            $table->string('title')->nullable();            
            $table->text('text');      
            $table->string('type')->default('vacancy');                   
            $table->string('link')->nullable();          
            $table->tinyInteger('status')->default(1);   
            $table->decimal('price', 10, 2)->default(0);  
            $table->date('start_date')->nullable();     
            $table->date('end_date')->nullable();        
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
        Schema::dropIfExists('text_ads');
    }
};
