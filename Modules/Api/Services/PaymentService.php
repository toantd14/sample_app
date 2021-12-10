<?php


namespace Modules\Api\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function payment($arrParams)
    {
        try {
            $url = config('payment.url_api_member_payment') . '?' . implode('&', array_map(
                    function ($v, $k) {
                        return $k . '=' . $v;
                    },
                    $arrParams,
                    array_keys($arrParams)
                ));

            $client = new Client();
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode(); // 200
            $contentType = $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'

            $result = $response->getBody();

            $arrPayReturn = [];
            $arrResult = explode('&', $result);

            if (!is_array($arrResult)) {
                Log::error(__FILE__ . ' ' . __LINE__ . ': Payment fail, URL call API payment: ' . $url);
                Log::error(__FILE__ . ' ' . __LINE__ . ': API payment return: statusCode = ' . $statusCode . ', contentType = ' . $contentType . ', body = ' . $result);

                return [
                    'status' => false,
                    'data' => $arrPayReturn
                ];
            }

            foreach ($arrResult as $item) {
                $arrItem = explode('=', $item);
                $arrPayReturn[$arrItem[0]] = $arrItem[1];
            }

            if ($arrPayReturn['rst'] != config('payment.api_rst_success')
                && $arrPayReturn['ec'] != config('payment.api_ec_success')
            ) {
                Log::error(__FILE__ . ' ' . __LINE__ . ': Payment fail, URL call API payment: ' . $url);
                Log::error(__FILE__ . ' ' . __LINE__ . ': API payment return: statusCode = ' . $statusCode . ', contentType = ' . $contentType . ', body = ' . $result);

                return [
                    'status' => false,
                    'data' => $arrPayReturn
                ];
            }

            return [
                'status' => true,
                'data' => $arrPayReturn
            ];
        } catch (\Exception $exception) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api payment has error == ' . $exception->getMessage());

            return [
                'status' => false,
                'data' => []
            ];
        }
    }
}
