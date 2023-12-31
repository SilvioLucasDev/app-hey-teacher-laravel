<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    public function publish(User $user, Question $question): bool
    {
        return $question->created_by === $user->id;
    }

    public function update(User $user, Question $question): bool
    {
        return $question->draft && $question->created_by === $user->id;
    }

    public function archive(User $user, Question $question): bool
    {
        return $question->created_by === $user->id;
    }

    public function destroy(User $user, Question $question): bool
    {
        return $question->created_by === $user->id;
    }
}
