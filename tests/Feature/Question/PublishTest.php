<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = put(route('question.publish', $question));

    //Assert :: Verificar
    $request->assertRedirect();
    $question->refresh();
    expect($question)->draft->toBeFalse();
});
