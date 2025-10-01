<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Gate::before(function ($user, $ability) {
//            dump($user, $ability);
//            $user->assignRole(1);
            if($ability!='Guest') {
                return $user->hasRole('Super Admin') ? true : null;
            }
            return null;
        });

        Gate::define('viewPulse', function (User $user) {
            return true;
        });
        LogViewer::auth(function ($request) {
            // return true to allow viewing the Log Viewer.
            return $request->user()
                && $request->user()->hasRole('Super Admin');
        });
    }
}
