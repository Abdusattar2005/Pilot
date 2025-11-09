<?php

namespace App\Actions\Info;

use App\Models\InfoUser;

class UpdateInfoUserAction
{
    public function handle(
        int $user_id,
        string $name,
        int $age,
        int $total_flight_time = 0,
        int $salary_min = 0,
        int $salarie_type_id = 1,
        ?string $country = null,
        ?string $region = null,
        ?string $city = null,
    ): InfoUser 
    {
        return InfoUser::updateOrCreate(
            [
                'user_id' => $user_id
            ],
            [
                'name' => $name,
                'age' => $age,
                'country' => $country,
                'region' => $region,
                'city' => $city,
                'total_flight_time' => $total_flight_time,
                'salary_min' => $salary_min,
                'salarie_type_id' => $salarie_type_id,
            ]
        );
    }
}
