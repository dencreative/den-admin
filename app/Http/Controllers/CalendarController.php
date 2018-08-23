<?php

namespace App\Http\Controllers;

use App\User;
use App\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $current = $today->startOfMonth();

        $users = User::all();
        $upcoming = Holiday::getStartsInDateRange($today->copy()->addDay(), $today->copy()->addMonth(), 'approved');
        $holidays_today = Holiday::getByDate(Carbon::today(), 'approved');
        $pending = Holiday::getByMonth($today->year, $today->month, 'pending');

        return view('calendar.index', compact('holidays_today', 'current', 'upcoming', 'pending', 'users'));
    }

//    public function show($year, $month)
//    {
//        $current = Carbon::createFromDate($year, $month, 1);
//        $users = User::all();
//        dd($users);
//        return view('calendar.show', compact('current', 'users'));
//    }

    public function create() {
        return view('calendar.create');
    }
}
