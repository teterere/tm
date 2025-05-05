<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Managers\DemoSessionManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureDemoSessionIsValid
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }

        if (!Session::has('sandbox_company_id')) {
            return $next($request);
        }

        $company = Company::find(Session::get('sandbox_company_id'));

        if (DemoSessionManager::isExpired($company)) {
            DemoSessionManager::deleteOldDemoCompany($company);

            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
            }

            DemoSessionManager::deleteDemoDataFromSession();

            if (!request()->routeIs('home')) {
                return redirect()->route('home')->with('demo_expired', true);
            }
        }

        return $next($request);
    }
}
