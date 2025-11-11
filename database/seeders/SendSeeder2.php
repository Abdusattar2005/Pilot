<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SendSeeder2 extends Seeder
{

    public function run()
    {
        DB::table('list_salaries')->insert([
            'id' => 1,
            'name' => "Не активно",
        ]);
        DB::table('list_salaries')->insert([
            'id' => 2,
            'name' => "Активно",
        ]);
    }
} 