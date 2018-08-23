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

    public function length(Carbon $date = null) {
        if($date === null)
            $date = $this->start_date;
        return $date->diffInDays($this->end_date->copy()->addDay());
    }

    public function workingLength() {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function returnDate() {
        $returnDate = self::nextWorkingDay($this->end_date);
        $days = Carbon::today()->diffInDays($returnDate);
        if ($days === 1) {
            return " Till tomorrow";
        }
        if ($days === -1) {
            return "Till yesterday";
        }
        return 'Till ' . $returnDate->diffForHumans();
    }

    public static function getByUser(User $user)
    {
        return self::where('user_id', '=', $user->id)->get();
    }

    public static function getByStatus(string $status)
    {
        return self::where('status', '=', $status)->get();
    }

    public static function getByDate(Carbon $date, string $status = null)
    {
        $holidays = self::where(function ($query) use ($date) {
            $query->where('start_date', '<=', $date);
            $query->where('end_date', '>=', $date);
        });

        if ($status !== null)
            $holidays = $holidays->where('status', $status);

        return $holidays->get();
    }

    public static function getByDateRange(Carbon $from, Carbon $to, string $status = null)
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

    public static function getByMonth(int $year, int $month, string $status = null)
    {
        $current = Carbon::createFromDate($year, $month, 1);
        return self::getByDateRange($current->copy()->startOfMonth(), $current->copy()->endOfMonth(), $status);
    }

    public static function getStartsInDateRange(Carbon $from, Carbon $to, string $status = null)
    {
        $start = $from->copy();
        $end = $to->copy();

        $holidays = self::whereBetween('start_date', [$start, $end]);

        if ($status !== null)
            $holidays = $holidays->where('status', $status);

        return $holidays->get();
    }

    public static function holidaysToDays($holidays, Carbon $start = null, Carbon $end = null){
        $dates = [];
        foreach($holidays as $holiday)
        {
            if($start == null)
                $start = $holiday->start_date;
            else
                $start = $start->max($holiday->start_date);

            if($end == null)
                $end = $holiday->start_date;
            else
                $end = $end->max($holiday->end_date);

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
