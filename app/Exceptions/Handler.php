<?php namespace APOSite\Exceptions;

use APOSite\Http\Controllers\LoginController;
use APOSite\Http\Requests\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Response;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if($e instanceof TokenMismatchException && $request->wantsJson()){
			return response()->json(['error'=>'reload'],401);
		}
        if($e instanceof ModelNotFoundException){
			if($request->wantsJson()){
				return response()->json(['error'=>'Resource Not Found.'],404);
			} else {
				return view('errors.404');
			}
        }
		if($e->getStatusCode() == 403 && $request->wantsJson()){
			return response()->json(['error'=>$e->getMessage()],403);
		}
		return parent::render($request, $e);
	}

}
