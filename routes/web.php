<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\QuizController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Quiz;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* --------------------------------Api-------------------------------- */
// Get Time
Route::get('/get-time', function () {
    return response(['now' => time()], 200);
});

/* --------------------------------Route-------------------------------- */
// ---------Home Page
Route::get('/', function () {
    return Inertia::render('Home/Home');
});
// ---------Dashboard Page
Route::get('/dashboard', [IndexController::class, 'dashboard'])->middleware(['auth:sanctum', 'verified'])->name('dashboard');


// ---------Teacher Quiz

// Create Quiz Page
Route::get('/create/quiz', [QuizController::class, function () {
    return Inertia::render('Quiz/CreateQuiz');
}])->name(('create.quiz'))->middleware(['auth:sanctum', 'verified']);

// Create Quiz Backend
Route::post('/create/quiz', [QuizController::class, 'store'])->name('store.quiz')->middleware(['auth:sanctum', 'verified']);

// Show Quiz Page
Route::get('/quiz/{uuid}', function ($uuid) {
    $quiz = Quiz::where('uuid', '=', $uuid)->get()[0];
    $quiz->questions;
    return Inertia::render('ShowQuizMaker/ShowQuiz', ['quiz' => $quiz]);
})->name('show.quiz')->middleware(['auth:sanctum', 'verified']);



// ---------Student Quiz

// Show Quiz Page
Route::get('/show/{uuid}', function ($uuid) {
    $quiz = Quiz::where('uuid', '=', $uuid)->get()[0];
    $quiz->questions;
    return Inertia::render('Student/ShowQuiz', ['quiz' => $quiz]);
})->name('ans.quiz')->middleware(['auth:sanctum', 'verified']);
