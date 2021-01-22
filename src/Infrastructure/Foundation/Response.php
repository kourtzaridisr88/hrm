<?php

namespace Hr\Infrastructure\Foundation;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;

class Response
{
    /**
     * Return's an empty response to SAPI.
     * 
     * @return EmptyResponse
     */
    public static function empty(): EmptyResponse
    {
        return new EmptyResponse();
    }
    
    /**
     * Return's a success json response to SAPI.
     * 
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function success($data, $message, $code = 200): JsonResponse
    {
        return new JsonResponse([
            'message' => $message, 
            'data' => $data
        ], $code);
    }

    /**
     * Return's an error json response to SAPI.
     * 
     * @param array $errors
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function error($errors = [], $message, $code = 500): JsonResponse
    {
        return new JsonResponse([
            'message' => $message, 
            'errors' => $errors
        ], $code);
    }
}