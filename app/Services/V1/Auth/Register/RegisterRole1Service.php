<?php

namespace App\Services\V1\Auth\Register;

use App\Actions\Info\UpdateInfoCompanyAction;

class RegisterRole1Service extends AbstractRegister
{
    protected function registerUser(): void
    {
        parent::createUser($this->roleId, $this->data['email'], $this->data['phone'], $this->data['password'], $this->code);
    }

    protected function createInfo(): void
    {
       $this->createInfoCompany();
    }

    private function createInfoCompany(): void
    {
        $service = new UpdateInfoCompanyAction();
        $service->handle($this->user->id, $this->data['company_name'],  $this->data['name'] ?? null);
    }

}
