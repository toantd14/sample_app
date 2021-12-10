<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Api\Emails\SendMailFeedback;
use Modules\Api\Traits\ResponseServerErrorTrait;
use Modules\Api\Transformers\QuestionTransformer;
use Modules\Api\Traits\ResponseUnauthorizedTraits;
use Modules\Api\Http\Requests\Question\FeedbackRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Modules\Api\Http\Requests\Question\GetQuestiosByCategoryRequest;
use Modules\Api\Repositories\Question\ApiQuestionRepositoryInterface;
use Modules\Api\Repositories\QuestionCategory\ApiQuestionCategoryRepositoryInterface;

class QuestionController extends Controller
{
    use ResponseServerErrorTrait;
    use ResponseUnauthorizedTraits;

    protected $questionCategoryRepository;
    protected $questionRepository;

    public function __construct(
        ApiQuestionCategoryRepositoryInterface $questionCategoryRepository,
        ApiQuestionRepositoryInterface $questionRepository
    ) {
        $this->questionCategoryRepository = $questionCategoryRepository;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('api::index');
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

    public function getByQuestionCategory(GetQuestiosByCategoryRequest $request)
    {
        try {
            $questionCategories = $this->questionCategoryRepository->show($request->categoryID);

            if ($questionCategories == null) {
                return response()->json([
                    "errors" => [
                        "message" => [__('message.question_category_not_found')]
                    ]
                ], Response::HTTP_NOT_FOUND);
            } else {
                $questions = $this->questionRepository->getQuestionsByCategory($request->categoryID, $request->pageSize);

                return response()->json([
                    "data" => fractal()->collection($questions, new QuestionTransformer())
                        ->toArray(),
                    'total' => $questions->total(),
                    'totalPage' => $questions->lastPage()
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->handleResponseServerError();
        }
    }

    public function feedback(FeedbackRequest $request)
    {
        if ($request->header('Authorization') && (Auth::guard('api')->user() == null)) {
            return $this->handleResponseUnauthorized();
        }

        try {
            Mail::to(env('FEEDBACK_SEND_TO_MAIL'))->send(new SendMailFeedback($request->feedback));

            return response()->json([
                "result" => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleResponseServerError();
        }
    }
}
