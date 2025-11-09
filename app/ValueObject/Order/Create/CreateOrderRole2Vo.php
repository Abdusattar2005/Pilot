<?php

namespace App\ValueObject\Order\Create;

use Illuminate\Validation\Rule;

class CreateOrderRole2Vo extends AbstractCreateOrderVo
{
    protected function rules():array{
        return [
           ...$this->rulesCreateOrderStep1(),
           ...$this->rulesCreateOrderStep2(),
           ...$this->rulesLicenses(),
           ...$this->rulesTotal_flight_time(),
           ...$this->rulesSalary(),
           ...$this->rulesWorkingDays(),
        ];
    }
}