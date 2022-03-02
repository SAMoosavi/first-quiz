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
use Date\Jalali;
use Date\Date;

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
            'start' => !!$request->start ? (new Jalali($request->start))->toGregorian()->format('Y-m-d H:i:s') : null,
            'end' => !!$request->end ? (new Jalali($request->end))->toGregorian()->format('Y-m-d H:i:s') : null,
            'time' => $request->time,
            'uuid' => (string)Str::uuid(),
        ]);

        foreach ($request->questions as $question) {
            Question::create([
                'questions' => $question['question'],
                'type' => $question['type'],
                'option' =>  json_encode($question['option']),
                'answer' => $question['answer'],
                'point' => (float)$question['point'],
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
            'start' => !!$request->start ? (new Jalali($request->start))->toGregorian()->format('Y-m-d H:i:s') : null,
            'end' => !!$request->end ? (new Jalali($request->end))->toGregorian()->format('Y-m-d H:i:s') : null,
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

        $studentQuiz = StudentQuiz::where('user_id', '=', $userId)->where('quiz_id', '=', $quiz->id)->first();
        $studentQuiz->update([
            'start' => $studentQuiz->created_at,
            'end' => date("Y-m-d H:i:s"),
        ]);
        return Redirect::route('dashboard');
    }

    public function showStudent(Quiz $uuid)
    {
        $quiz = $uuid;
        $user = User::find(auth()->id());
        if ($quiz->user_id != $user->id) {
            $now = strtotime(date("Y-m-d H:i:s"));

            if (!!$quiz->start && $now < strtotime($quiz->start)) {
                $time = strtotime($quiz->start) - $now;
                $seconds = $time % 60;
                $time = floor($time / 60);
                $minutes = $time % 60;
                $time = floor($time / 60);
                $hours = $time;
                $time = $hours . ":" . $minutes . ":" . $seconds;

                return Inertia::render('Student/NotStart', ['uuid' => $uuid, 'now' => $now, 'start' => $now, 'time' => $time]);
            } elseif (!!$quiz->end && $now > strtotime($quiz->end)) {
                $studentQuiz = StudentQuiz::where('user_id', '=', $user->id)->where('quiz_id', '=', $quiz->id)->first();
                $questions = $quiz->questions->map(function ($question) {
                    $ans  = Answer::where('question_id', '=', $question->id)->where('user_id', '=', auth()->id())->first();
                    return [
                        'id' => $question->id,
                        'questions' => $question->questions,
                        'type' => $question->type,
                        'option' => json_decode($question->option),
                        'answer' => $question->answer,
                        'point' => $question->point,
                        'quiz_id' => $question->quiz_id,
                        'answerStudent' => $ans->answer,
                        'pointStudent' => $ans->point,
                    ];
                });
                return Inertia::render('Student/ResultQuiz', ['quiz' => $quiz, 'questions' =>  $questions, 'studentQuiz' => $studentQuiz]);
            } else {

                if (!StudentQuiz::where('user_id', '=', $user->id)->where('quiz_id', '=', $quiz->id)->get()->isEmpty()) {
                    $studentQuiz = StudentQuiz::where('user_id', '=', $user->id)->where('quiz_id', '=', $quiz->id)->first();
                    if (!$studentQuiz->end) {
                        $quiz->questions;
                        return Inertia::render('Student/ShowQuiz', ['quiz' => $quiz, 'start' => strtotime($studentQuiz->start), 'now' => $now]);
                    } else {
                        $questions = $quiz->questions->map(function ($question) {
                            $ans  = Answer::where('question_id', '=', $question->id)->where('user_id', '=', auth()->id())->first();
                            return [
                                'id' => $question->id,
                                'questions' => $question->questions,
                                'type' => $question->type,
                                'option' => json_decode($question->option),
                                'answer' => $question->answer,
                                'point' => $question->point,
                                'quiz_id' => $question->quiz_id,
                                'answerStudent' => $ans->answer,
                                'pointStudent' => $ans->point,
                            ];
                        });
                        return Inertia::render('Student/ResultQuiz', ['quiz' => $quiz, 'questions' =>  $questions, 'studentQuiz' => $studentQuiz]);
                    }
                } else {
                    $quiz->questions;

                    StudentQuiz::create([
                        'start' => date("Y-m-d H:i:s"),
                        'end' => null,
                        'quiz_id' => $quiz->id,
                        'user_id' => $user->id,
                    ]);
                    return Inertia::render('Student/ShowQuiz', ['quiz' => $quiz, 'start' => $now, 'now' => $now]);
                }
            }
        } else {
            return redirect()->route('show.quiz', ['uuid' => $quiz->uuid]);
        }
    }
    function showTeacher(Quiz $uuid)
    {
        $quiz = $uuid;
        $quiz->questions;
        $quiz->start = !!$quiz->start ? (new Date($quiz->start))->toJalali()->format('Y/m/d H:i:s') : null;
        $quiz->end = !!$quiz->end ? (new Date($quiz->end))->toJalali()->format('Y/m/d H:i:s') : null;

        $students = StudentQuiz::where('quiz_id', "=", $quiz->id)->get();
        $student = collect();
        foreach ($students as $item) {
            $ans = collect([]);
            foreach ($quiz->questions as $value) {
                $answer = Answer::where('question_id', "=", $value->id)->where('user_id', "=", $item->user_id)->first();
                $ans->push([
                    'answerStudent' => $answer->answer,
                    'pointStudent' => $answer->point,
                    'type' => $value->type,
                    'questions' => $value->questions,
                    'option' => json_decode($value->option),
                    'answer' => $value->answer,
                    'id' => $value->id,
                    'point' => $value->point,
                ]);
            }
            $student->push(['ans' => $ans, 'student' => User::find($item->user_id), 'point' => $item->point]);
        }

        return Inertia::render('ShowQuizMaker/ShowQuiz', ['quiz' => $quiz, 'student' => $student]);
    }
}
