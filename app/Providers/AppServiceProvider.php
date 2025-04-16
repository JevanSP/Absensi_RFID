<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

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
    public function boot()
    {
        View::composer('partials.header_siswa', function ($view) {
            $user = Auth::user();

            if ($user && $user->role === 'siswa') {
                $siswa = Siswa::where('id', $user->siswa_id)->first();
            } else {
                $siswa = null;
            }

            $view->with(compact('user', 'siswa'));
        });
    }
}
