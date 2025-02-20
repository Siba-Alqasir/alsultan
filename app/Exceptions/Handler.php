<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;
use App\Models\Page;
use App\Http\Controllers\Web\NavigationController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Exceptions\PostTooLargeException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [//
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = ['password', 'password_confirmation',];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof PostTooLargeException) {
            Log::info('PostTooLargeException caught');
            return redirect()->back()->withInput()->with('error', 'File size is too large');
        }
        if ($exception instanceof UnauthorizedException) {
            return response()->view('errors.unauthorized');
        }

        if ($exception instanceof NotFoundHttpException) {
            $page = Page::where('key', 'not-found-page')->first();
            $data = (new NavigationController)->mutual('404');
            $data['page'] = $page;
            $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
            return response()->view('errors.404', ['data' => $data], 404);
        }
        Log::info(json_encode($exception->getMessage()));

        return parent::render($request, $exception);
    }
}
