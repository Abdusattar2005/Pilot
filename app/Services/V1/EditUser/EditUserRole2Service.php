<?php

namespace App\Services\V1\EditUser;

use App\Services\V1\EditUser\AbstractEditUser;

class EditUserRole2Service extends AbstractEditUser
{
    protected function handle(): void
    {
       $this->updateUserInfo();
       $this->createUserWorkingDay();//раб дни
       $this->createUserPlanes();//самолеты
       $this->createUserLicenses();//лицензии
       $this->createUserContract();//контракт
       $this->createUserPosition();//должность
    }

}
