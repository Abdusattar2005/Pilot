<?php

namespace App\Actions\UserContract;

use App\Models\UserContract;

class UpdateUserContractAction
{

    public function handle(int $user_id, int $contractId)
    {
        UserContract::updateOrCreate(
            [
                'user_id' => $user_id,
            ],
            [
                'contract_id' => $contractId,
            ]
        );
    }
}
