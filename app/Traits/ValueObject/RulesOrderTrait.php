<?php

namespace App\Traits\ValueObject;

use Illuminate\Validation\Rule;

trait RulesOrderTrait
{

    public function rulesCreateOrderStep1(): array
    {
        return [
            'position_id' => "required|integer|exists:list_positions,id",
            "contract_id" => "required|integer|exists:list_contracts,id",
            'plane_id' => 'required|integer|exists:list_planes,id',
            'comment' => 'nullable|string|max:250',
        ];
    }

    public function rulesCreateOrderStep2(): array
    {
        return [
            'departure' => "required|string|max:250",
            'departure_date' => "required|date_format:Y-m-d",
            'arrival' => "nullable|string|max:250",
            'arrival_date' => "nullable|date_format:Y-m-d",
        ];
    }

    public function rulesLicenses(): array
    {
        return [
            'license'  => 'array',
            'license.*.id' => 'required|distinct|integer|exists:list_licenses,id',
        ];
    }

    public function rulesTotal_flight_time(): array
    {
        return [
            "total_flight_time" => "nullable|integer|min:0|max:999999999",
        ];
    }

    public function rulesSalary(): array
    {
        return [
            "salary_min" => "nullable|integer|min:0|max:999999999",
            "salarie_type_id" => "nullable|integer|exists:list_salaries,id",
        ];
    }

    public function rulesWorkingDays(): array
    {
        return [
            'working_days'  => 'array',
            'working_days.*.date' => 'required|distinct|date_format:Y-m-d',
        ];
    }
}
