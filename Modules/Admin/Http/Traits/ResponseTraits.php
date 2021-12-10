<?php

namespace Modules\Admin\Http\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseTraits
{
    public function handleErrorResponse()
    {
        return response()->json([
            'message' => __('message.error')
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
