<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    public function update(Question $id, Request $request)
    {
        $request->validate([
            'questions' => "required|string",
            'option' => 'nullable|array',
            'answer' => 'nullable|string',
            'uuid' => 'required|string',
        ]);

        $id->update([
            'questions' => $request->questions,
            'option' => json_encode($request->option),
            'answer' => json_encode($request->answer),
        ]);

        return  back()->withInput();
    }
}
