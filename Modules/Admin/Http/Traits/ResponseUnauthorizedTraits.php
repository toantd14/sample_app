<?php

namespace Modules\Admin\Http\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseUnauthorizedTraits
{
    public function handleUnauthorizedResponse()
    {
        return response()->json([
            'unauthorized' =>  __('message.post_message.unauthorized')
        ], Response::HTTP_OK);
    }
}
