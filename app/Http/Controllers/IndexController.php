<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\StudentQuiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Date\Date;

class IndexController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $makers = $user->quizzesMaker->map(function ($quiz) {
            $quiz->start = !!$quiz->start ? (new Date($quiz->start))->toJalali()->format('Y/m/d H:i')  : null;
            $quiz->end = !!$quiz->end ? (new  Date($quiz->end))->toJalali()->format('Y/m/d H:i')  : null;
            return $quiz;
        });
        $participants =  StudentQuiz::where('user_id', '=', $user->id)->get()->map(function ($ids) {

            $quiz = Quiz::find($ids->quiz_id);
            $quiz->start = !!$quiz->start ? (new Date($quiz->start))->toJalali()->format('Y/m/d H:i')  : null;
            $quiz->end = !!$quiz->end ? (new  Date($quiz->end))->toJalali()->format('Y/m/d H:i')  : null;
            return $quiz;
        });
        return Inertia::render('Dashboard/Dashboard', ['makers' => $makers, 'participants' => $participants]);
    }
}
