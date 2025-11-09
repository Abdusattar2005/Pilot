<?php

namespace App\Services\V1\EditUser;

use App\Actions\Info\UpdateInfoCompanyAction;
use App\Services\V1\EditUser\AbstractEditUser;

class EditUserRole1Service extends AbstractEditUser
{
    protected function handle(): void
    {
       $this->editInfoCompany();
    }

    private function editInfoCompany(): void
    {
        $service = new UpdateInfoCompanyAction();
        $service->handle($this->user->id, $this->data['company_name'],  $this->data['name'] ?? null);
    }

}
