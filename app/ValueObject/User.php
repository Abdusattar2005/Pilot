<?php

namespace App\ValueObject;

use App\Models\Admin;
use App\Models\Owner;
use App\Models\Staff;

class User
{
    private Admin|Owner|Staff $value;
    private array $fullRoles = [
        1 => "superadmin",
        2 => "admin",
        3 => "owner",
        4 => "administrator",
        5 => "employee",
        6 => "courier",
    ];
    private array $accessRoles = [];

    public function __construct($value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    //модель
    public function getValue(): Admin|Owner|Staff
    {
        return $this->value;
    }

    //роль строкой
    public function getRoleString(): string
    {
        return $this->value->roles->first()->name;
    }

    //дотсупные роли доступа
    protected function addAccessRole(int $value): void
    {
        if(empty($this->fullRoles[$value])) CustomException(1011);
        $this->accessRoles[] = $this->fullRoles[$value];
    }

    private function validate($value): void
    {
        if (!is_object($value)) CustomException(1013);
        if (
            !method_exists($value, 'getTable') ||
            !method_exists($value, 'roles')
        ) CustomException(1013);

        $role = match ($value->getTable()) {
            'owners' => 'owners',
            'staff' => 'staff',
            'admins' => 'admins',
            default => CustomException(1013)
        };

        $role = $value->roles->first()->name;

        //если сущ accessRoles то смотрим доступ по нему, иначе по фул ролям
        if(!in_array($role,
            count($this->accessRoles) == 0 ? $this->fullRoles : $this->accessRoles)
        ) CustomException(1013);
    }
}
