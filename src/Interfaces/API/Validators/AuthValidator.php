<?php

namespace Hr\Interfaces\Api\Validators;

use Laminas\Diactoros\ServerRequest;
use Hr\Infrastructure\Contracts\ValidatorInterface;
use Respect\Validation\Validator;
use Hr\Infrastructure\Exceptions\ValidationException;

class AuthValidator implements ValidatorInterface
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
            'email' => [
                'rule' => Validator::email(),
                'message' => 'The email field is required and should be a valid email address!'
            ],
            'password' => [
                'rule' => Validator::stringType()->notEmpty(),
                'message' => 'The password field is required!'
            ],
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