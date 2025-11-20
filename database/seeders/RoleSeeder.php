<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'company']);
        Role::firstOrCreate(['name' => 'tech_staff']);
        Role::firstOrCreate(['name' => 'pilot']);
        Role::firstOrCreate(['name' => 'flight_attendant']);
    }
}
