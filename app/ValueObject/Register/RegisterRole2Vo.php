<?php

namespace App\ValueObject\Register;

use App\Models\Role;
use Illuminate\Validation\Rule;

class RegisterRole2Vo extends AbstractRegisterVo
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
            ...$this->rulesStep2(),
            
            "position" => [
                "required","integer",
                Rule::exists('list_positions','id')->where(function ($query) {
                    return $query->where('role_id', Role::ROLE_PILOT);
                }),
            ],
            
            ...$this->rulesTotal_flight_time(),
            ...$this->rulesLicense(),

        ];
    }
}