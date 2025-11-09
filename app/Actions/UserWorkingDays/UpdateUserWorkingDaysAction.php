<?php

namespace App\Actions\UserWorkingDays;

use App\Models\UserWorkingDay;
use Illuminate\Support\Collection;

class UpdateUserWorkingDaysAction
{
    //$dates список дат 2024-01-01 2024-01-02 //$service->handle($this->user->id, collect(['2024-01-03'])); 
    public function handle(int $user_id, Collection $dates)
    {
        UserWorkingDay::where('user_id', $user_id) //удаляем
            ->whereNotIn('day', $dates) //удалить все что нету в этом списке
            ->delete();

        foreach ($dates as $day) {
            UserWorkingDay::firstOrCreate([
                'user_id' => $user_id,
                'day' => $day,
            ]);
        }
    }
}
