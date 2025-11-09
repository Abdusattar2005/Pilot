<?php

namespace App\ValueObject\EditUser;

use Illuminate\Validation\Rule;

class EditUserRole1Vo extends AbstractEditUserVo
{
    public function __construct($value){
        parent::setMess([
            'email.unique' => 'this email address is already occupied, select another one',
        ]);  
        parent::__construct($value);
    }

    protected function rules():array{
        return [
            ...$this->rulesEditUserEmail(),
            ...$this->rulesphone(),
            ...$this->rulesName(),
            "company_name" => "required|string|min:1|max:250",
        ];
    }
}