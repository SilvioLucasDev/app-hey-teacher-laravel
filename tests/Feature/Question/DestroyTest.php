<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete};

it('should be able to destroy a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = delete(route('question.destroy', $question));

    //Assert :: Verificar
    $request->assertRedirect();
    assertDatabaseMissing('questions', ['id' => $question->id]);
});

it('should make sure that only the person who has created the question can destroy the question', function () {
    // Arrange :: Preparar
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $rightUser->id, 'draft' => true]);
    actingAs($wrongUser);

    // Act :: Agir
    $request = delete(route('question.destroy', $question));

    //Assert :: Verificar
    $request->assertForbidden();

    // Arrange :: Preparar
    actingAs($rightUser);

    // Act :: Agir
    $request = delete(route('question.destroy', $question));

    //Assert :: Verificar
    $request->assertRedirect();
});
