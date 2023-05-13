<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'question' => [
                'required',
                'min:10',
                function ($attribute, $value, Closure $fail) {
                    if($value[strlen($value) - 1] != '?') {
                        $fail('Are you sure that is a question? It is missing a question mark in the end.');
                    }
                },
            ],
        ]);
        Question::query()->create($attributes);

        return to_route('dashboard');
    }
}
