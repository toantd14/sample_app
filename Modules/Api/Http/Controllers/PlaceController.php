<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Modules\Api\Http\Requests\Place\GetAutocompleteRequest;
use Modules\Api\Http\Requests\Place\GetDetailRequest;
use Modules\Api\Traits\CurlTraits;
use Symfony\Component\HttpFoundation\Response;

class PlaceController extends Controller
{
    use CurlTraits;

    public function getAutocomplete(GetAutocompleteRequest $request)
    {
        $arrayQuery = [
            'input' => $request->keyword,
            'type' => config('constants.URL.PLACE.RESPONSE_TYPE'),
            'language' => config('constants.URL.PLACE.LANGUAGE'),
            'location' => $request->lat . ',' . $request->lon,
            'key' => config('constants.URL.PLACE.KEY')
        ];
        $urlDetail = config('constants.URL.PLACE.AUTOCOMPLETE') . '?' . Arr::query($arrayQuery);
        try {
            $place = $this->getDataCurl($urlDetail);
            $dataResponse = null;
            foreach ($place['predictions'] as $prediction) {
                $dataResponse[] = [
                    "place_id" => $prediction['place_id'],
                    "description" => $prediction['description']
                ];
            }

            return response()->json(
                [
                    'message' => __('message.success'),
                    'data' => $dataResponse
                ], Response::HTTP_OK
            );
        } catch (HttpResponseException $e) {
            Log::error($e->getMessage());

            return response()->json(
                [
                    'message' => __('message.error')
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getDetail(GetDetailRequest $request)
    {
        $arrayQuery = [
            'place_id' => $request->place_id,
            'key' => config('constants.URL.PLACE.KEY')
        ];
        $urlDetail = config('constants.URL.PLACE.DETAIL') . '?' . Arr::query($arrayQuery);

        try {
            $place = $this->getDataCurl($urlDetail);
            $location = $place['result']['geometry']['location'] ?? null;
            $dataResponse = null;
            if ($location) {
                $dataResponse = [
                    'lat' => $place['result']['geometry']['location']['lat'],
                    'lon' => $place['result']['geometry']['location']['lng']
                ];
            }

            return response()->json(
                [
                    'message' => __('message.success'),
                    'data' => $dataResponse
                ], Response::HTTP_OK
            );
        } catch (HttpResponseException $e) {
            Log::error($e->getMessage());

            return response()->json(
                [
                    'message' => __('message.error')
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
