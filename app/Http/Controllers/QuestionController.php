<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!str($value)->endsWith('?')) {
                        $fail('Are you sure that is a question? It is missing the question mark in the end.');
                    }
                },
            ],
        ]);

        Question::query()->create(
            $data
        );

        return redirect()->route('dashboard');
    }
}
