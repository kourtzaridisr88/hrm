<?php

namespace Hr\Interfaces\API\Validators;

use Hr\Infrastructure\Exceptions\ValidationException;
use Hr\Infrastructure\Contracts\ValidatorInterface;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator;

class DepartmentsValidator implements ValidatorInterface
{
    public $request;

    public $validated = [];

    public function __construct(ServerRequest $request)
    {
        $this->request = $request;
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'rule' => Validator::stringType()->notEmpty(),
                'message' => 'The name field is required!'
            ]
        ];
    }

    public function validate()
    {
        $errors = [];
        $data = $this->request->getParsedBody();

        foreach ($this->rules() as $key => $rule) {
            $result = $rule['rule']->validate($data[$key] ?? null);

            if ($result === false) {
                $errors[$key] = $rule['message'];
            } else {
                $this->validated[$key] = $data[$key];
            }
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}