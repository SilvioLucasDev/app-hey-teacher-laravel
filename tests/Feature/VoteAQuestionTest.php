<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it('should be able to like a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    // Act :: Agir
    post(route('question.like', $question->id))
        ->assertRedirect();

    //Assert :: Verificar
    assertDatabaseHas('votes', [
        'like'    => 1,
        'unlike'  => 0,
        'user_id' => $user->id,
    ]);
});
