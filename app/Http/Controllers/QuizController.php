<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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
}
