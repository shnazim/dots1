<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\Mailer\Exception\TransportException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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

    public function render($request, Throwable $e)
    {
        if ($e instanceof TransportException) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => 'SMTP Configuration is incorrect !']);
            } else {
                return redirect()->route('login')->with('error', 'SMTP Configuration is incorrect !');
            }
        }

        if ($e instanceof TokenMismatchException) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => 'Your session has expired, please try again !']);
            } else {
                return redirect()->back()->with('error', 'Your session has expired, please try again !');
            }
        }

        return parent::render($request, $e);
    }
}
