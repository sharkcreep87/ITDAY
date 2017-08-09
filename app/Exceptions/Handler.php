<?php

namespace App\Exceptions;

use Exception;
use JWTAuth;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        if ($exception instanceof QueryException) 
        {
            if ($request->expectsJson()) 
            {
                return response()->json(['message' => $exception->getMessage()], 500);
            }
            return redirect(url()->previous())->with('message',$exception->getMessage())->with('status','error');;
        }

        if ($exception instanceof \PDOException) 
        {
            if ($request->expectsJson()) 
            {
                return response()->json(['message' => $exception->getMessage()], 500);
            }
            return redirect(url()->previous())->with('message',$exception->getMessage())->with('status','error');;
        }

        elseif ($exception instanceof NotFoundHttpException) 
        {
            if ($request->expectsJson()) 
            {
                return response()->json(['message' => 'Not Found'], 404);
            }
            return response()->view('errors.404');
        }

        else
        {
            $err['message'] = $exception->getMessage();
            $err['code'] = $exception->getCode();
            $err['file'] = $exception->getFile();
            $err['line'] = $exception->getLine();
            if ($request->expectsJson()) 
            {
                return response()->json($err, 500);
            }
            return response()->view('errors.500', $err);
        }
        
        return parent::render($request, $exception);
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

        return redirect()->guest(route('login'));
    }


}
