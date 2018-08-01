<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Show the application dashboard.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $greetings = [
            'Hello', 'Hi', 'Hey', 'Greetings', 'Salutations'
        ];
        $greeting = $greetings[array_rand($greetings,1)];
        return view('dashboard', compact('greeting'));
    }
}
