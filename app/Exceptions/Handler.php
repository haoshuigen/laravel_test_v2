<?php

namespace App\Exceptions;

use App\Http\Trait\ResponseTrait;
use App\Service\SqlLogService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|HttpResponse|View
     * @throws Throwable
     */
    public function render($request, Throwable $e):JsonResponse|HttpResponse|View
    {
        if ($e instanceof QueryException) {
            try {
                SqlLogService::record($e, '');
            } catch (Exception $childException) {
                Log::error('Failed to log query exception: ', ['exception' => $childException]);
            }

            return $this->general(1,
                ['code' => 1, 'msg' => $e->getMessage(), 'wait' => 5, 'url' => url('admin/index/index')],
                500
            );
        }

        return parent::render($request, $e);
    }
}
