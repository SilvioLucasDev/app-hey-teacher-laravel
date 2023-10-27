<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted, patch};

it('should be able to archive a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = patch(route('question.archive', $question));

    //Assert :: Verificar
    $request->assertRedirect();
    assertSoftDeleted('questions', ['id' => $question->id]);
    expect($question)->refresh()->deleted_at->not->toBeNull();
});

it('should make sure that only the person who has created the question can archive the question', function () {
    // Arrange :: Preparar
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $rightUser->id, 'draft' => true]);
    actingAs($wrongUser);

    // Act :: Agir
    $request = patch(route('question.archive', $question));

    //Assert :: Verificar
    $request->assertForbidden();

    // Arrange :: Preparar
    actingAs($rightUser);

    // Act :: Agir
    $request = patch(route('question.archive', $question));

    //Assert :: Verificar
    $request->assertRedirect();
});

it('should be able to restore an archived question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true, 'deleted_at' => now()]);
    actingAs($user);

    // Act :: Agir
    $request = patch(route('question.restore', $question));

    //Assert :: Verificar
    $request->assertRedirect();
    assertNotSoftDeleted('questions', ['id' => $question->id]);
    expect($question)->refresh()->deleted_at->toBeNull();
});
