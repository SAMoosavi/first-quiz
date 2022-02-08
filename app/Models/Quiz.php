<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\User;


class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'time',
        'user_id',
        'uuid',
    ];

    public function maker(){
        return $this->belongsTo(User::class);
    }

    public function participant()
    {
        return $this->belongsToMany(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


}
