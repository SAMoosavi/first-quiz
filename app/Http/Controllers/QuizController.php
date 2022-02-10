<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use App\Models\StudentQuiz;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\map;

class QuizController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'name' => "required|string",
            'start' => 'nullable|string',
            'end' => 'nullable|string',
            'time' => 'nullable|string',
        ]);

        $user = Auth::user();

        $quiz = Quiz::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'start' => $request->start,
            'end' => $request->end,
            'time' => $request->time,
            'uuid' => (string)Str::uuid(),
        ]);

        foreach ($request->questions as $question) {
            Question::create([
                'questions' => $question['question'],
                'type' => $question['type'],
                'option' =>  json_encode($question['option']),
                'answer' => json_encode($question['answer']),
                'quiz_id' => $quiz->id,
                'uuid' => (string)Str::uuid(),
            ]);
        }

        return Redirect::route('show.quiz', ['uuid' => $quiz->uuid]);
    }

    public function update(Quiz $id, Request $request)
    {
        $request->validate([
            'name' => "required|string",
            'start' => 'nullable|string',
            'end' => 'nullable|string',
            'time' => 'required|string',
        ]);

        $id->update([
            'name' => $request->name,
            'start' => $request->start,
            'end' => $request->end,
            'time' => $request->time,
        ]);

        return  back()->withInput();
    }

    public  function send(Request $request)
    {
        $userId = Auth::user()->id;
        foreach ($request->answer as $ans) {
            Answer::create([
                'type' => $ans['type'],
                'answer' => $ans['ans'],
                'user_id' => $userId,
                'question_id' => $ans['id'],
            ]);
        }
        $quiz =  Question::find($request->answer[0]['id'])->quiz;

        StudentQuiz::where('user_id', '=', $userId)->where('quiz_id', '=', $quiz->id)->get()[0]->update([
            'end' => date("Y-m-d H:i:s"),
        ]);
        return Redirect::route('dashboard');
    }

    public function show($uuid)
    {
        $quiz = Quiz::where('uuid', '=', $uuid)->get()[0];
        $quiz->questions;
        $user = User::find(auth()->id());

        if (!StudentQuiz::where('user_id', '=', $user->id)->where('quiz_id', '=', $quiz->id)->get()->isEmpty()) {
            $a = StudentQuiz::where('user_id', '=', $user->id)->where('quiz_id', '=', $quiz->id)->get()[0];
            if (!$a->end) {
                return Inertia::render('Student/ShowQuiz', ['quiz' => $quiz, 'start' => strtotime($a->start), 'now' => strtotime(date("Y-m-d H:i:s"))]);
            } else {
                dd($a);
                // return Inertia::render('Student/ShowQuiz', ['quiz' => $quiz]);
            }
        } else {
            StudentQuiz::create([
                'start' => date("Y-m-d H:i:s"),
                'end' => null,
                'quiz_id' => $quiz->id,
                'user_id' => $user->id,
            ]);
            return Inertia::render('Student/ShowQuiz', ['quiz' => $quiz, 'start' => strtotime(date("Y-m-d H:i:s")), 'now' => strtotime(date("Y-m-d H:i:s"))]);
        }
    }
}
