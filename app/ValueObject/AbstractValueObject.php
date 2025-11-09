<?php

namespace App\ValueObject;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


abstract class AbstractValueObject
{
    private $value;
    private $valueValidated;
    private $mess = [];
    public array $attributes = [];//заменяем названия атрибутов

    public function __construct($value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function setMess(array $mess): void
    {
       $this->mess = $mess;
    }

    public function setAttributes(array $attributes): void
    {
       $this->attributes = $attributes;
    }
    /**
     * Gets the value of the property.
     *
     * @return Collection The value of the property.
     */
    public function getValue(): Collection
    {
        return collect($this->value);
    }

    /**
     * Returns a Collection of the validated values.
     *
     * @return Collection
     */
    public function getValueValidated(): Collection
    {
        return collect($this->valueValidated);
    }

    public function getValueValidatedObject(): object
    {
        return (object) $this->valueValidated;
    }

    abstract protected function rules(): array;

    protected function validate($value): void
    {
        //d($this->rules());
        $this->valueValidated = Validator::make($value, $this->rules(), $this->mess, $this->attributes)->validate();
    }
}
