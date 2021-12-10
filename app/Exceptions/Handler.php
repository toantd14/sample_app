<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Query\QueryException;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof InvalidFormatException) {
            return $this->errorResponse(__('message.response.invalid_format_datetime_exception'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            if (!$request->is('api/*')) {
                return redirect('404');
            } else {
                return $this->errorResponse(trans('message.response.url_not_exist'), 404);
            }
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse(trans('message.response.url_not_exist'), Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof NotFoundHttpException  && $request->wantsJson()) {
            return $this->errorResponse(trans('message.response.url_not_exist'), Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json([
                'message' => _('message.response.url_not_exist')
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof QueryException && $request->wantsJson()) {
            return response()->json([
                'message' => __('message.error')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse(trans('message.response.http_internal_server_error'), 500);
    }
}
