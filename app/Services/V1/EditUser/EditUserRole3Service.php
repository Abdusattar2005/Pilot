<?php

namespace App\Services\V1\EditUser;

use App\Services\V1\EditUser\AbstractEditUser;

class EditUserRole3Service extends AbstractEditUser
{
    protected function handle(): void
    {
        $this->updateUserInfo();
        $this->createUserWorkingDay(); //раб дни
        $this->createUserPlanes(); //самолеты       
        $this->createUserContract(); //контракт
        $this->createUserPosition(); //должность
    }
}
