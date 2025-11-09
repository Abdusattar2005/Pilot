<?php

namespace App\ValueObject\Order\Create;

use App\Traits\ValueObject\RulesOrderTrait;
use App\Traits\ValueObject\RulesUserTrait;
use App\ValueObject\AbstractValueObject;

abstract class AbstractCreateOrderVo extends AbstractValueObject
{
    use RulesOrderTrait;
}
