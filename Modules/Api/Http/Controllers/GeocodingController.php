<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Modules\Api\Http\Requests\Place\SearchAddressRequest;
use Symfony\Component\HttpFoundation\Response;


class GeocodingController extends Controller
{
    public function searchZipcodeInfo(SearchAddressRequest $request)
    {
        $arrayQuery = [
            'address' => $request['zipcode'],
            'region' => config('constants.URL.PLACE.REGION'),
            'language' => config('constants.URL.PLACE.LANGUAGE'),
            'key' => config('constants.KEY_GEOCODING_API')
        ];

        $url = config('constants.URL.GEOCODING_URL') . '?' . Arr::query($arrayQuery);
        $resp_json = file_get_contents($url);
        $response = json_decode($resp_json, true);

        try {
            if ($response['status'] == config('constants.RESPONSE_STATUS_OK')) {
                $dataAddress = $response['results'][0]['address_components'];

                return response()->json([
                    'zipCd' => $dataAddress[0]['long_name'] ,
                    'prefectures' => $dataAddress[3]['long_name'] ,
                    'municipality' => $dataAddress[2]['long_name'] ,
                    'townname' => $dataAddress[1]['long_name'] ,
                ], Response::HTTP_OK);
            }

            return response()->json([
                "errors" => [
                    "message" => [__('message.zipcode_not_found')]
                ]
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(
                [
                    'message' => __('message.error')
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


}
