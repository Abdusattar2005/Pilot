<?php

namespace App\ValueObject\Register;

use Illuminate\Validation\Rule;

class RegisterRole1Vo extends AbstractRegisterVo
{
    public function __construct($value){
        parent::setMess([
            'email.unique' => 'this email address is already occupied, select another one',
        ]);
        parent::setAttributes([
            'email' => 'email',
        ]);
        
        parent::__construct($value);
    }
    protected function rules():array{
        return [
            ...$this->rulesStep1(),

            "name" => "required|string|min:1|max:100",
            "company_name" => "required|string|min:1|max:250",
        ];
    }
}