<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Api\Traits\ResponseServerErrorTrait;
use Modules\Api\Repositories\QuestionCategory\ApiQuestionCategoryRepositoryInterface;
use Modules\Api\Transformers\QuestionCategoryTransformer;

class QuestionCategoryController extends Controller
{
    use ResponseServerErrorTrait;

    protected $questionCategoryRepository;

    public function __construct(ApiQuestionCategoryRepositoryInterface $questionCategoryRepository)
    {
        $this->questionCategoryRepository = $questionCategoryRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $questionCategories = $this->questionCategoryRepository->getNewQuestionCategories();

            $questionCategories = fractal()->collection($questionCategories)
                ->transformWith(new QuestionCategoryTransformer())
                ->toArray();

            return response()->json([
                "data" => $questionCategories,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleResponseServerError();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('api::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('api::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('api::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
