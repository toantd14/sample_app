<?php

namespace Modules\Api\Traits;

use Illuminate\Http\Response;

trait ResponseServerErrorTrait
{
    public function handleResponseServerError()
    {
        return response()->json([
            "errors" => [
                "message" => [__('message.response.http_internal_server_error')]
            ]
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function handleResponseNotFoundError()
    {
        return response()->json([
            "errors" => [
                "message" => [__('message.response.url_not_exist')]
            ]
        ], Response::HTTP_NOT_FOUND);
    }
}
