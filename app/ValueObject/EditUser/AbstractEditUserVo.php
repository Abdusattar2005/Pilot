<?php

namespace App\ValueObject\EditUser;

use App\Traits\ValueObject\RulesUserTrait;
use App\ValueObject\AbstractValueObject;

abstract class AbstractEditUserVo extends AbstractValueObject
{
    use RulesUserTrait;
}
