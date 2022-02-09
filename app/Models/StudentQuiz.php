<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\User;

class StudentQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'user_id',
        'quiz_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Quiz::class);
    }
}
