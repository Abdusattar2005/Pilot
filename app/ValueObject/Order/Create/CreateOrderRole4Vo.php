<?php

namespace App\ValueObject\Order\Create;

use Illuminate\Validation\Rule;

class CreateOrderRole4Vo extends AbstractCreateOrderVo
{
    protected function rules():array{
        return [
           ...$this->rulesCreateOrderStep1(),
           ...$this->rulesCreateOrderStep2(),
           ...$this->rulesSalary(),
           ...$this->rulesWorkingDays(),
        ];
    }
}