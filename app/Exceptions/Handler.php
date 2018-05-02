<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        switch (true) {
            case $exception instanceof AuthorizationException:
                return response()->view('admin.errors.unauthorized', [], 404);
                break;
            case $exception instanceof ModelNotFoundException:
                return response()->view('admin.errors.404', [], 404);
                break;
            case $exception instanceof NotFoundHttpException:
                return response()->view('admin.errors.404', [], 404);
                break;
            default:
                return parent::render($request, $exception);
        }

        /*if ($exception instanceof ModelNotFoundException) {
            // return your custom response
            return response()->view('admin.errors.404', [], 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            // return your custom response
            return response()->view('admin.errors.404', [], 404);
        }

        return parent::render($request, $exception);*/
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guards = $exception->guards();
        if (!empty($guards[0])) {
            $guard = $guards[0];
            switch ($guard) {
                case config('auth.guards.web.name'):
                    return redirect()->guest(route('web.login'));
                    break;
                case config('auth.guards.admin.name'):
                    return redirect()->guest(route('admin.login'));
                    break;
                default:
                    return redirect()->guest(route('web.home'));
            }
        }
        return redirect()->guest(route('web.home'));
        //return redirect()->guest(route('admin.login'));
    }
}
