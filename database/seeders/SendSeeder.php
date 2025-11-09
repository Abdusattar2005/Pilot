<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SendSeeder extends Seeder
{

    public function run()
    {
        DB::table('list_planes')->insert([
            'id' => 1,
            'name' => "Falcon",
        ]);
        DB::table('list_planes')->insert([
            'id' => 2,
            'name' => "B-737",
        ]);
        DB::table('list_planes')->insert([
            'id' => 3,
            'name' => "A-320",
        ]);

//////////////////////

        DB::table('list_contracts')->insert([
            'id' => 1,
            'name' => "Freelance",
        ]);
        DB::table('list_contracts')->insert([
            'id' => 2,
            'name' => "Ferry",
        ]);
        DB::table('list_contracts')->insert([
            'id' => 3,
            'name' => "Full time",
        ]);

///////////////////////
        DB::table('list_licenses')->insert([
            'id' => 1,
            'name' => "FAA",
        ]);
        DB::table('list_licenses')->insert([
            'id' => 2,
            'name' => "EASA",
        ]);
        DB::table('list_licenses')->insert([
            'id' => 3,
            'name' => "Other ICAO",
        ]);


//////////////

        DB::table('list_positions')->insert([            
            'name' => "Captain",
            'role_id' => 2,
        ]);
        DB::table('list_positions')->insert([            
            'name' => "FO",
            'role_id' => 2,
        ]);

        DB::table('list_positions')->insert([            
            'name' => "Senior Flight Attendants",
            'role_id' => 3,
        ]);
        DB::table('list_positions')->insert([            
            'name' => "Flight Attendants",
            'role_id' => 3,
        ]);

        DB::table('list_positions')->insert([            
            'name' => "Aircraft Mechanic",
            'role_id' => 4,
        ]);
        DB::table('list_positions')->insert([            
            'name' => "Aviation Technician",
            'role_id' => 4,
        ]);
        DB::table('list_positions')->insert([            
            'name' => "Avionics Technician",
            'role_id' => 4,
        ]);
        DB::table('list_positions')->insert([            
            'name' => "Other",
            'role_id' => 4,
        ]);

    }
}