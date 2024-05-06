<?php

namespace App\Http\Controllers;

use App\Models\Till;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
    public static function closeMonthReminder()
    {
        $unclosedTills = Till::whereHas('monthlyEntries', function ($query) {
                $query->where('open_date', now()->startOfMonth()->format('Y-m-d'))
                    ->whereNull('close_date');
            })->get();

        foreach ($unclosedTills as $unclosedTill) {
            
        }
    }
}
