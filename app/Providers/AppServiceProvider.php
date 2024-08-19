<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Databse\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
        Model::preventLazyLoading();

        // define a gate that checks for user authorization to edit a job (must be the user who created the job)
//        Gate::define('edit-job', function (User $user, Job $job) {
            // returns boolean
//            return $job->employer->user->is($user);
//       });
    }
}
