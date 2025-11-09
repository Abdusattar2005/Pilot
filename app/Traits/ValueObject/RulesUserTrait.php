<?php
namespace App\Traits\ValueObject;

use Illuminate\Validation\Rule;

trait RulesUserTrait
{

    public function rulesEditUserEmail(): array
    {
        return [            
            "email" => [
                "required","email",
                Rule::unique('users','email')->where(function ($query) {
                    return $query->where('id', '!=', auth()->user()->id ?? 0);
                }),
            ],
        ];
    }

    public function rulesEmail(): array
    {
        return [
            "email" => "required|email|unique:users",
        ];
    }
    public function rulesPassword(): array
    {
        return [
            'password' => 'required|string|min:8|max:50',
        ];
    }
    
    public function rulesPhone(): array
    {
        return [
            'phone' => 'required|integer|digits_between:10,20',
        ];
    }
    
    public function rulesLicense(): array
    {
        return [            
            'license'  => 'required|array',
            'license.*.id' => 'required|distinct|integer|exists:list_licenses,id',
        ];
    }

    public function rulesTotal_flight_time(): array
    {
        return [            
            "total_flight_time" => "required|integer|min:0|max:999999999",
        ];
    }

    public function rulesName(): array
    {
        return [            
            "name" => "required|string|min:1|max:100",
        ];
    }

    public function rulesStep1(): array
    {
        return [
            ...$this->rulesEmail(),
            ...$this->rulesPassword(),
            ...$this->rulesPhone(),
            'confirm_password' => 'required|same:password',
        ];
    }

    public function rulesStep2(): array
    {
        return [
            "name" => "required|string|min:1|max:100",
            "age" => "required|integer|min:15|max:100",

            "country" => "nullable|string|min:1|max:100",
            "region" => "nullable|string|min:1|max:100",
            "city" => "nullable|string|min:1|max:100",

            "salary_min" => "required|integer|min:0|max:999999999",
            "salarie_type_id" => "integer|exists:list_salaries,id",

            'working_days'  => 'required|array',
            'working_days.*.date' => 'required|distinct|date_format:Y-m-d',

            'planes'  => 'required|array',
            'planes.*.id' => 'required|distinct|integer|exists:list_planes,id',

            "contract" => "required|integer|exists:list_contracts,id",
        ];
    }

}

