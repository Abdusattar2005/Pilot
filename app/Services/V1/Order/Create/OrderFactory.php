<?php

namespace App\Services\V1\Order\Create;

use App\Models\Role;
use App\ValueObject\Order\Create\CreateOrderRole2Vo;
use App\ValueObject\Order\Create\CreateOrderRole3Vo;
use App\ValueObject\Order\Create\CreateOrderRole4Vo;

class OrderFactory
{
    public static function handle(int $position_id, array $request): AbstractOrder
    {
        $role = \App\Models\ListPosition::select('role_id')->find($position_id);        
        
        return match ($role->role_id ?? 0) {            
            Role::ROLE_PILOT => new CreateOrderRole2Service(new CreateOrderRole2Vo($request)),
            Role::ROLE_FILIGHT_ATTENDANT => new CreateOrderRole3Service(new CreateOrderRole3Vo($request)),
            Role::ROLE_TECH_STAFF => new CreateOrderRole4Service(new CreateOrderRole4Vo($request)),
           default => CustomException(1023)
        };
    }
}
