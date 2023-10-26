<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to update a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ]);

    //Assert :: Verificar
    $request->assertRedirect();
    $question->refresh();
    expect($question)->question->toBe('Updated Question?');
});
