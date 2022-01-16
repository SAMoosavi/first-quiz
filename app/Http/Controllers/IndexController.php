<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function dashboard()
    {
        $user =Auth::user();
        $makers = $user->quizzesMaker;
        $participants = $user->quizzesParticipants;
        return Inertia::render('Dashboard/Dashboard', ['makers' => $makers, 'participants' => $participants]);

    }
}
