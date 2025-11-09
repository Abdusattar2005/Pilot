<?php

namespace App\Actions\UserLicense;

use App\Models\UserLicense;
use Illuminate\Support\Collection;

class UpdateUserLicensesAction
{
    //$service->handle($this->user->id, collect([1,2]));//ид 
    public function handle(int $user_id, Collection $licenseIds)
    {
        UserLicense::where('user_id', $user_id) //удаляем
            ->whereNotIn('license_id', $licenseIds) //удалить все что нету в этом списке
            ->delete();

        foreach ($licenseIds as $planeId) {
            UserLicense::firstOrCreate([
                'user_id' => $user_id,
                'license_id' => $planeId,
            ]);
        }
    }
}
