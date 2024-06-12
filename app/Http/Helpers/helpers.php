<?php

use App\Models\MonthlyEntry;

function sanitizeNumber($number)
{
    $number = str_replace(',', '', $number);
    if (str_ends_with($number, '.')) {
        $number = substr($number, 0, -1);
    }

    return $number;
}

function checkMonthlyOpening($tillId)
{
    $currentMonth = now()->startOfMonth()->toDateString();
    $monthlyEntry = MonthlyEntry::where('till_id', $tillId)->where('open_date', $currentMonth)->whereNull('close_date')->first();
    throw_if(!$monthlyEntry, new Exception("No monthly opening found in the current month for the selected till!"));
}

function getMatchCategory($match)
{
    return $match->type == "Knockouts" ? $match->knockoutRound->tournamentLevelCategory->levelCategory : $match->group->tournamentLevelCategory->levelCategory;
}

function getMatchRound($match)
{
    return $match->type == "Knockouts" ? $match->knockoutRound->name : $match->group->name;
}
