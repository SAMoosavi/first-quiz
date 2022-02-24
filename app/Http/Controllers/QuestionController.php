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
            'point'=>'required|numeric',
            'uuid' => 'required|string',
        ]);

        $id->update([
            'questions' => $request->questions,
            'option' => json_encode($request->option),
            'answer' => $request->answer,
            'point' => $request->point,
        ]);

        return  back()->withInput();
    }
}
