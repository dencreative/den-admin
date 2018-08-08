<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Holiday extends Model
{
    protected $table = 'users_holidays';

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function length() {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function workingLength() {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function returnDate() {
        $returnDate = self::nextWorkingDay($this->end_date);
//        $diffInDays = Carbon::today()->diffInDays($returnDate);
//        return $diffInDays . ' day'. ($diffInDays == 1 ? '' : 's') . ' from now';
        $days = Carbon::today()->diffInDays($returnDate);
        if ($days === 1) {
            return " Till tomorrow";
        }
        if ($days === -1) {
            return "Till yesterday";
        }
        return 'Till ' . $returnDate->diffForHumans();
    }

    public static function getByUser($user)
    {
        return self::where('user_id', '=', $user->id);
    }

    public static function getByStatus($status)
    {
        return self::where('status', '=', $status);
    }

    public static function getByDate($date, $status = null)
    {
        $holidays = self::where(function ($query) use ($date) {
            $query->where('start_date', '<=', $date);
            $query->where('end_date', '>=', $date);
        });

        if ($status !== null)
            $holidays = $holidays->where('status', $status);

        return $holidays->get();
    }

    public static function getByDateRange($from, $to, $status = null)
    {
        $start = $from->copy();
        $end = $to->copy();

        $holidays = self::where(function ($query) use ($start, $end) {
            $query->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end]);
        });

        if ($status !== null)
            $holidays = $holidays->where('status', $status);

        return $holidays->get();
    }

    public static function getByMonth($year, $month, $status = null)
    {
        $current = Carbon::createFromDate($year, $month, 1);
        return self::getByDateRange($current->copy()->startOfMonth(), $current->copy()->endOfMonth(), $status);
    }

    public static function getStartsInDateRange($from, $to, $status = null)
    {
        $start = $from->copy();
        $end = $to->copy();

        $holidays = self::whereBetween('start_date', [$start, $end]);

        if ($status !== null)
            $holidays = $holidays->where('status', $status);

        return $holidays->get();
    }


    public static function daysInMonth($year = null, $month = null) {
        $current = Carbon::createFromDate($year, $month);
        $startOfMonth = $current->copy()->startOfMonth();
        $endOfMonth = $current->copy()->endOfMonth();
        $holidays = self::where(function ($query) use (&$startOfMonth, &$endOfMonth) {
            $query->whereBetween('start_date', array($startOfMonth->toDateString(),  $endOfMonth->toDateString()))
                ->orWhereBetween('end_date', array($startOfMonth->toDateString(),  $endOfMonth->toDateString()));
        })->get();

        $dates = [];
        foreach($holidays as $holiday)
        {
            $start = $startOfMonth->max($holiday->start_date);
            $end = $endOfMonth->min($holiday->end_date);
            $period = self::date_range($start, $end, true);
            foreach($period as $date){
                $dates[$date->day] = $holiday->status;
            }
        }
        return $dates;
    }
    private static function date_range(Carbon $from, Carbon $to, $inclusive = true)
    {
        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        if ($inclusive) {
            $to->addDay();
        }

        $step = CarbonInterval::day();
        $period = new \DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon($day);
        }

        return ! empty($range) ? $range : null;
    }

    private static function nextWorkingDay($day) {
        $current = $day->copy()->addDay();
        while($current->isWeekend())
        {
            $current->addDay();
        }
        return $current;
    }
}
