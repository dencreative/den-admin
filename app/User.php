<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function hasRole($role)
    {
        if (is_string($role))
            $role = $this->roles()->where('name', $role)->first();

        return null !== $role;
    }

    public function addRole($role) {
        if (is_string($role))
            $role = Role::where('name', $role)->first();

        $this->roles()->attach($role);
    }

    public function removeRole($role) {
        if (is_string($role))
            $role = Role::where('name', $role)->first();

        $this->roles()->detatch($role);
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if($role->hasPermission($permission))
                return true;
        }
        return false;
    }

    public function holidays()
    {
        return Holiday::getByUser($this);
    }

    public function test($year, $month)
    {
        $current = Carbon::createFromDate($year, $month);
        $startOfMonth = $current->copy()->startOfMonth();
        $endOfMonth = $current->copy()->endOfMonth();
        $holidays = DB::table('users_holidays')
            ->where('user_id', '=', $this->id)
            ->where(function ($query) use (&$startOfMonth, &$endOfMonth) {
                $query->whereBetween('start_date', array($startOfMonth->toDateString(),  $endOfMonth->toDateString()))
                    ->orWhereBetween('end_date', array($startOfMonth->toDateString(),  $endOfMonth->toDateString()));
            })
            ->get();

        $dates = [];
        foreach($holidays as $holiday)
        {
            $start = $startOfMonth->max($holiday->start_date);
            $end = $endOfMonth->min($holiday->end_date);
            $period = $this->date_range($start, $end, true);
            foreach($period as $date){
                $dates[$date->day] = $holiday->status;
            }
        }
        return $dates;
    }

    private function date_range(Carbon $from, Carbon $to, $inclusive = true)
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
}
