<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('info_users', function (Blueprint $table) {            
            $table->unsignedBigInteger('salarie_type_id')->default(1);
            $table->foreign('salarie_type_id')->references('id')->on('list_salaries')->onDelete('cascade')->onUpdate('restrict');     
        });
    }

    public function down()
    {
        Schema::table('info_users', function (Blueprint $table) {
            $table->dropColumn([
                'salarie_type_id'
            ]);
        });
    }
};
