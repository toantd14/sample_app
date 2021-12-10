<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Api\Repositories\UseTerm\UseTermRepositoryInterface;

class UseTermController extends Controller
{
    protected $useTermRepository;

    public function __construct(
        UseTermRepositoryInterface $useTermRepository
    )
    {
        $this->useTermRepository = $useTermRepository;
    }

    public function getUseTerm(Request $request) {
        $useTerm = $this->useTermRepository->getUseTerm();

        return [
            'data' =>$useTerm['use_terms']
        ];
    }
}
