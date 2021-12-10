<?php

namespace Modules\Api\Traits;

use Illuminate\Support\Facades\Http;

trait CurlTraits
{
    public function getDataCurl($url, $header = [])
    {
        return Http::withHeaders($header)
            ->get($url);
    }
}
