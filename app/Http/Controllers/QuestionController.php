<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => user()->questions,
        ]);
    }
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

        return back();
    }
    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }
}
