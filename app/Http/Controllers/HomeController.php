<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friend_ids = Friend::where('user_id', Auth::id())->pluck('to_user_id');
        $friends = User::whereIn('id', $friend_ids)->get(['id', 'name']);

        return view('home', compact('friends'));
    }
}
