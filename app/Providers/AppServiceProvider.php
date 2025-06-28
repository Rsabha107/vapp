<?php

namespace App\Providers;

use App\Models\GeneralSettings\Setting;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Workspace;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        //Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // if (Schema::hasTable('settings')) {
        //     $settings = Setting::all()->pluck('value', 'key')->toArray();
            //  Log::info('Settings loaded from database', $settings);
        //     config(['settings' => $settings]);  // Load the settings dynamically into Laravel's config
       //  }

        if ($this->app->environment('azure')) {
            URL::forceScheme('https');
        }

        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols();
        });


        Carbon::setWeekendDays([
            Carbon::FRIDAY,
            Carbon::SATURDAY,
        ]);

        try {
            DB::connection()->getPdo();
            // The table exists in the database
            $statuses = Status::all();
            // $user_workspace = auth()->user()->workspaces;
            $workspaces = Workspace::all();
            // $user_events = auth()->user()->events;

            // dd($workspaces);

            $data = [   'statuses' => $statuses,
                        // 'user_events' => $user_events,
                        'workspaces' => $workspaces,
                    ];

            view()->share($data);
        } catch (\Exception $e) {
        }

    }
}
