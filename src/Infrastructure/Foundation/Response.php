<?php

namespace Hr\Infrastructure\Foundation;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;

class Response
{
    public static function empty(): EmptyResponse
    {
        return new EmptyResponse();
    }
    
    public static function success($data, $message, $code = 200): JsonResponse
    {
        return new JsonResponse([
            'message' => $message, 
            'data' => $data
        ], $code);
    }

    public static function error($errors = [], $message, $code = 500): JsonResponse
    {
        return new JsonResponse([
            'message' => $message, 
            'errors' => $errors
        ], $code);
    }
}