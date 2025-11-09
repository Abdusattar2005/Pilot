<?php

namespace App\Services\V1\Auth\Register;

//регистрация пилота
class RegisterRole2Service extends AbstractRegister
{
    protected function registerUser(): void
    {
        parent::createUser($this->roleId, $this->data['email'], $this->data['phone'], $this->data['password'], $this->code);
    }

    protected function createInfo(): void
    {
        $this->createUserInfo();
        $this->createUserWorkingDay();//раб дни
        $this->createUserPlanes();//самолеты
        $this->createUserLicenses();//лицензии
        $this->createUserContract();//контракт
        $this->createUserPosition();//должность
    }
}
