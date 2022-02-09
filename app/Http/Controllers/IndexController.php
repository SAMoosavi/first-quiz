<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\StudentQuiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $makers = $user->quizzesMaker;
        $participants =  StudentQuiz::where('user_id', '=', $user->id)->get()->map(function ($ids) {
            return Quiz::find($ids->quiz_id);
        });
        return Inertia::render('Dashboard/Dashboard', ['makers' => $makers, 'participants' => $participants]);
    }
}
