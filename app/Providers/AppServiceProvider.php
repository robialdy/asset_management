<?php

namespace App\Providers;

use App\Models\Recommendation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFour();

        View::composer('template.templateAdmin', function ($view) {
            $submissionCount = Recommendation::where('is_read', 0)->where('category', 'Submission')->where('status', 'Under Review')->count();
            $rejuvenationCount = Recommendation::where('is_read', 0)->where('category', 'rejuvenation')->where('status', 'Under Review')->count();
            $returnCount = Recommendation::where('is_read', 0)->where('category', 'return')->where('status', 'Under Review')->count();
            $allCount = $submissionCount + $rejuvenationCount + $returnCount;

            $view->with([
                'submissionCount' => $submissionCount,
                'rejuvenationCount' => $rejuvenationCount,
                'returnCount' => $returnCount,
                'allCount' => $allCount
            ]);
        });
    }
}
