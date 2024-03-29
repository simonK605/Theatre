<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// Models
use App\Models\Theatre;

class PagesController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * @return \Inertia\Response
     */
    public function home()
    {
        return Inertia::render('Home', [
            'user' => Auth::user(),
            'theatres' => Theatre::orderBy('theatres.id', 'desc')
                ->leftJoin('bookings', function ($join) {
                    $join->on('theatres.id', '=', 'bookings.theatre_id')
                        ->where('bookings.user_id', Auth::user()->id);
                })
                ->select('theatres.*', 'bookings.id as booked_id')
                ->get()
        ]);
    }
}
