<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserCreatedException extends Exception
{
    public function report()
    {
        \Log::debug('Review not found');
    }

    public function render($request)
    {
        return response()->json(
            [
                "errors" => [
                    'message' => __('message.response.unauthorized')
                ]
            ],
            Response::HTTP_NOT_FOUND
        );
    }

}
