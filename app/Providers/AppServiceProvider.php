<?php

namespace App\Providers;

use App\Repositories\Contracts\ScoreFormulaQuizRepositoryInterface;
use App\Repositories\ScoreFormulaQuizRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ScoreFormulaQuizRepositoryInterface::class, ScoreFormulaQuizRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
