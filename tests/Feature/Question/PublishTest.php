<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = put(route('question.publish', $question));

    //Assert :: Verificar
    $request->assertRedirect();
    $question->refresh();
    expect($question)->draft->toBeFalse();
});

it('should make sure that only the person who has created the question can publish the question', function () {
    // Arrange :: Preparar
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $rightUser->id, 'draft' => true]);
    actingAs($wrongUser);

    // Act :: Agir
    $request = put(route('question.publish', $question));

    //Assert :: Verificar
    $request->assertForbidden();

    // Arrange :: Preparar
    actingAs($rightUser);

    // Act :: Agir
    $request = put(route('question.publish', $question));

    //Assert :: Verificar
    $request->assertRedirect();
});
