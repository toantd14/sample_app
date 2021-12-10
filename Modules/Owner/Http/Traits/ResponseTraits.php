<?php

namespace Modules\Owner\Http\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseTraits
{
    public function handleErrorResponse()
    {
        return response()->json([
            'message' => __('message.error')
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function handleErrorResponseCustomMessage($errorMessage, $responseMessage)
    {
        return response()->json([
            "errors" => [
                'message' => [$errorMessage],
            ]
        ], $responseMessage);
    }

    public function handleNotFoundException($message)
    {
        return response()->json([
            'message' => $message
        ], Response::HTTP_NOT_FOUND);
    }

    public function handleInternalServerException($message)
    {
        return response()->json([
            "errors" => [
                "message" => $message
            ]
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function handleUnprocessableEntity($message)
    {
        return response()->json([
            "errors" => [
                "message" => $message
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
