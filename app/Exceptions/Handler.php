<?php

namespace APOSite\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Illuminate\Support\Facades\Auth;


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
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof MissingScopeException) {
            ;
            return response()->json([
                'error' => 'Token is not authorized for scope(s): ' .
                    '[' .
                    join(', ', $exception->scopes()) .
                    ']' .
                    '\n' .
                    'Token scopes: [' .
                    join(', ', Auth::user()->token()->scopes) . ']',
            ]);
        }
        if ($exception instanceof TokenMismatchException && $request->wantsJson()) {
            return response()->json(['error' => 'reload'], 401);
        }
        if ($exception instanceof ModelNotFoundException) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Resource Not Found.'], 404);
            } else {
                return response(404)->view('errors.404');
            }
        }
        if (($exception instanceof ValidationException) &&
            $exception->getStatusCode() == 403 &&
            $request->wantsJson()
        ) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }
        if ($request->wantsJson()) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest('login');
    }
}
