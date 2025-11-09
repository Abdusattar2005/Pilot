<?php

namespace App\Actions\Info;

use App\Models\InfoCompany;

class UpdateInfoCompanyAction
{
    public function handle(int $user_id, string $company_name, ?string $name = null):InfoCompany
    {
        return InfoCompany::updateOrCreate(
            [
                'user_id' => $user_id
            ],
            [
                'name' => $name,
                'company_name' => $company_name
            ]
        );
    }
}
