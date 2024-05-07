<?php

namespace App\Http\Controllers;

use App\Models\Till;
use App\Services\MailService;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
    public static function closeMonthReminder()
    {
        $unclosedTills = Till::whereHas('monthlyEntries', function ($query) {
                $query->whereDate('open_date', '<=', now()->startOfMonth()->format('Y-m-d'))
                    ->whereNull('close_date');
            })
            ->with(['user'])
            ->get();

        $mailService = new MailService();

        foreach ($unclosedTills as $till) {
            $mailService->notify($till->user, "Close Month Reminder", "Please, this is a reminder to close your $till->name month before it ends.");
        }
    }
}
