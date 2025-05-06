<?php

namespace App\Managers;

use App\Models\Company;
use App\Models\TaskComment;
use App\Models\User;
use Artisan;
use Auth;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TaskSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DemoSessionManager
{
    public const DURATION_MINUTES = 30;

    public static function expiresAt(): Carbon
    {
        return now()->addMinutes(self::DURATION_MINUTES);
    }

    public static function isExpired(): bool
    {
        $company = Company::find(Session::get('sandbox_company_id'));

        if (!$company) {
            return true;
        }

        return $company->created_at->lessThan(now()->subMinutes(self::DURATION_MINUTES));
    }

    public static function loginDemoUser(User $user = null): void
    {
        $user = $user ?? User::find(Session::get('sandbox_user_id'));

        Auth::login($user);
    }

    public static function deleteOldDemoCompany(): void
    {
        $company = Company::find(Session::get('sandbox_company_id'));

        if (!$company) {
            return;
        }

        $company->tasks()->delete();
        $company->employees()->delete();
        TaskComment::whereIn('task_id', $company->tasks()->pluck('id'))->delete();

        $company->delete();
    }

    public static function seedDemoData(Company $company): void
    {
        DatabaseSeeder::$targetCompany = $company;

        Artisan::call('db:seed', [
            '--class' => UserSeeder::class,
            '--class' => TaskSeeder::class
        ]);
    }

    public static function deleteDemoDataFromSession(): void
    {
        Session::forget(['sandbox_company_id', 'sandbox_user_id', 'sandbox_expires_at']);
    }

    public static function createDemoUser(Company $company)
    {
        $user = User::create([
            'name' => 'Demo Lietotājs',
            'email' => 'demo_' . Str::random(8) . '@example.com',
            'password' => bcrypt(Str::random(10)),
            'company_id' => $company->id,
        ]);

        Session::put('sandbox_user_id', $user->id);

        return $user;
    }

    public static function createDemoCompany()
    {
        $company = Company::create([
            'title' => 'Demo Uzņēmums - ' . Str::random(6),
            'is_demo' => true
        ]);

        Session::put('sandbox_company_id', $company->id);

        return $company;
    }

    public static function setExpiresAtTimestamp(): void
    {
        Session::put('sandbox_expires_at', now()->addMinutes(DemoSessionManager::DURATION_MINUTES)->timestamp);
    }
}
