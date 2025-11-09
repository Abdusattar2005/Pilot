<?php

namespace App\Actions\OrderWorkingDays;

use App\Models\OrderWorkingDay;
use Illuminate\Support\Collection;

class CreaterWorkingDaysAction
{
    //$dates список дат 2024-01-01 2024-01-02 //$service->handle($, collect(['2024-01-03'])); 
    public function handle(int $order_id, Collection $dates)
    {
        foreach ($dates as $day) {
            OrderWorkingDay::firstOrCreate([
                'order_id' => $order_id,
                'day' => $day,
            ]);
        }
    }
}
