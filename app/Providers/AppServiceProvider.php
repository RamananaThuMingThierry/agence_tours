<?php

namespace App\Providers;

use App\Interfaces\TourInterface;
use App\Interfaces\SlideInterface;
use App\Repositories\TourRepository;
use Illuminate\Pagination\Paginator;
use App\Repositories\SlideRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ReservationInterface;
use App\Interfaces\TestimonialInterface;
use App\Repositories\ReservationRepository;
use App\Repositories\TestimonialRepository;

class AppServiceProvider extends ServiceProvider
{
/**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TestimonialInterface::class, TestimonialRepository::class);
        $this->app->bind(SlideInterface::class, SlideRepository::class);
        $this->app->bind(ReservationInterface::class, ReservationRepository::class);
        $this->app->bind(TourInterface::class, TourRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
