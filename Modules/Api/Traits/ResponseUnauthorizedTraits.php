<?php

namespace Modules\Api\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait ResponseUnauthorizedTraits
{
    public function handleResponseUnauthorized()
    {
        return response()->json([
            "errors" => [
                "message" => [__('message.response.unauthorized')]
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }
}
