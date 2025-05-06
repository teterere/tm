<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->isMethod('post')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->route('home')->with('demo_expired', true);
    }

    public function register(): void
    {
        //
    }
}
