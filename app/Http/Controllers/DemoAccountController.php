<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Managers\DemoSessionManager;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class DemoAccountController extends Controller
{
    public function login(): RedirectResponse
    {
        if (Session::has('sandbox_company_id')) {
            $company = Company::find(Session::get('sandbox_company_id'));

            if ($company) {
                if (!DemoSessionManager::isExpired()) {
                    DemoSessionManager::loginDemoUser();

                    return redirect()->route('tasks.index');
                }

                Auth::logout();
                DemoSessionManager::deleteDemoDataFromSession();
                DemoSessionManager::deleteOldDemoCompany();
            }

            DemoSessionManager::deleteDemoDataFromSession();
        }

        $company = DemoSessionManager::createDemoCompany();
        $user = DemoSessionManager::createDemoUser($company);

        DemoSessionManager::seedDemoData($company);
        DemoSessionManager::setExpiresAtTimestamp();

        Auth::login($user);

        return redirect()->route('tasks.index');
    }
}
