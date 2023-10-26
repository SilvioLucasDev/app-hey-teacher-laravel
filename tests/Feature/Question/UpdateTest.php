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

it('should make sure that only question with status DRAFT can be updated', function () {
    // Arrange :: Preparar
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->create(['created_by' => $user->id, 'draft' => false]);
    $draftQuestion    = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $requestNotDraft = put(route('question.update', $questionNotDraft), [
        'question' => 'Updated Question?',
    ]);

    $requestDraft = put(route('question.update', $draftQuestion), [
        'question' => 'Updated Question?',
    ]);

    //Assert :: Verificar
    $requestNotDraft->assertForbidden();
    $requestDraft->assertRedirect();
});

it('should make sure that only the person who has created the question can update the question', function () {
    // Arrange :: Preparar
    $rightUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $rightUser->id, 'draft' => true]);
    actingAs($rightUser);

    // Act :: Agir
    $requestWrongUser = put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ]);

    //Assert :: Verificar
    $requestWrongUser->assertRedirect();

    // Arrange :: Preparar
    $wrongUser = User::factory()->create();
    actingAs($wrongUser);

    // Act :: Agir
    $requestRightUser = put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ]);

    //Assert :: Verificar
    $requestRightUser->assertForbidden();
});
