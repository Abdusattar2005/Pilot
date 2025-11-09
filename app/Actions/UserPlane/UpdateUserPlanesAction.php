<?php

namespace App\Actions\UserPlane;

use App\Models\UserPlane;
use Illuminate\Support\Collection;

class UpdateUserPlanesAction
{
    //$service->handle($this->user->id, collect([1,2]));//ид самолетов 
    public function handle(int $user_id, Collection $planeIds)
    {
        UserPlane::where('user_id', $user_id) //удаляем
            ->whereNotIn('plane_id', $planeIds) //удалить все что нету в этом списке
            ->delete();

        foreach ($planeIds as $planeId) {
            UserPlane::firstOrCreate([
                'user_id' => $user_id,
                'plane_id' => $planeId,
            ]);
        }
    }
}
