<?php

namespace App\Services\V1\Order\Create;

//создание зявки для пилота
class CreateOrderRole4Service extends AbstractOrder
{
    protected function handle(): void
    {
        parent::createWorkingDay();      
    }


}
