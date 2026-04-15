<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Post "Today in History" every morning at 8:00 AM
        $schedule->call(function () {
            $twitterService = app(\App\Services\TwitterService::class);
            $twitterService->postMorningHistory();
        })->dailyAt('08:00')->name('today-history')->withoutOverlapping();
        
        // Post "Did You Know" every evening at 6:00 PM
        $schedule->call(function () {
            $twitterService = app(\App\Services\TwitterService::class);
            $twitterService->postEveningTrivia();
        })->dailyAt('18:00')->name('did-you-know')->withoutOverlapping();
        
        // Clean up old AI sessions (keep last 30 days)
        $schedule->call(function () {
            \App\Models\AiSession::where('created_at', '<', now()->subDays(30))->delete();
        })->daily();
    }
}