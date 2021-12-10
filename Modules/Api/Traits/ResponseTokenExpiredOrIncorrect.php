<?php

namespace Modules\Api\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait ResponseTokenExpiredOrIncorrect
{
    public function handleResponseTokenExpiredOrIncorrect()
    {
        return response()->json([
            "errors" => [
                "message" => [__('message.response.token_expired_or_incorrect')]
            ]
        ], Response::HTTP_BAD_REQUEST);
    }
}
