<?php

namespace App\Actions\UserPosition;

use App\Models\UserContract;
use App\Models\UserPosition;

class UpdateUserPositionAction
{

    public function handle(int $user_id, int $positionId)
    {
        UserPosition::updateOrCreate(
            [
                'user_id' => $user_id,
            ],
            [
                'position_id' => $positionId,
            ]
        );
    }
}
