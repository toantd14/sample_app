<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Modules\Api\Repositories\ContractTemplate\ContractTemplateRepository;
use Symfony\Component\HttpFoundation\Response;

class ContractTemplateController extends Controller
{
    protected $contractTemplateRepository;

    public function __construct (ContractTemplateRepository $contractTemplateRepository) {
        $this->contractTemplateRepository = $contractTemplateRepository;
    }

    public function getContractTemplate()
    {
        try {
            $contractTemplate = $this->contractTemplateRepository->getContractTemplate();

            return response()->json([
                'data' => $contractTemplate->use_terms,
                'contractID' => $contractTemplate->serial_no
            ]);
        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api contract template fail == ' . $ex->getMessage());

            return response()->json([
                "errors" => [
                    "message" => [__('message.response.http_internal_server_error')]
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
