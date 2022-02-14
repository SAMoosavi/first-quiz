<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Edit Quize and Question
Route::put('/edit/quiz/{id}', [QuizController::class, 'update'])->name('edit.quize')->middleware(['auth:sanctum', 'verified']);
Route::put('/edit/question/{id}', [QuestionController::class, 'update'])->name('edit.question')->middleware(['auth:sanctum', 'verified']);

// Show Quiz Page
Route::get('/quiz/{uuid:uuid}', [QuizController::class, 'showTeacher'])->name('show.quiz')->middleware(['auth:sanctum', 'verified']);



// ---------Student Quiz

// Show Quiz Page
Route::get('/show/{uuid:uuid}', [QuizController::class, 'showStudent'])->name('ans.quiz')->middleware(['auth:sanctum', 'verified']);

// send answer
Route::post('/send-answer', [QuizController::class, 'send'])->name('send.answer');
