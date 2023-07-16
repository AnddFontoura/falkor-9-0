<?php

namespace App\Http\Controllers;

use App\Models\PlayerInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $playerInvitations = PlayerInvitation::where('email', Auth::user()->email)->get();
        
        return view('home', compact('playerInvitations'));
    }
}
