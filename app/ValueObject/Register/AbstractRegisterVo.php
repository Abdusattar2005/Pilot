<?php

namespace App\ValueObject\Register;

use App\Traits\ValueObject\RulesUserTrait;
use App\ValueObject\AbstractValueObject;

abstract class AbstractRegisterVo extends AbstractValueObject
{
    use RulesUserTrait;
}
