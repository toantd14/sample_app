<?php

namespace App\Traits;

trait ApiResponser
{
    public function successResponse($data, $message = null, $code = 200)
    {
        $response = [
            'message' => $message
        ];
        $response = array_merge($response, $data);

        return response()->json($response, $code);
    }

    public function errorResponse($message = null, $code)
    {
        return response()->json([
            "errors" => [
                "message" => $message
            ]
        ], $code);
    }
}

