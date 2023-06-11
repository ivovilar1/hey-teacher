<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        request()->validate([
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
        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }
}
