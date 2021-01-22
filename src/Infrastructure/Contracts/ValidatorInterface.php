<?php

namespace Hr\Infrastructure\Contracts;

interface ValidatorInterface
{
    public function validate();
    public function rules(): array; 
}