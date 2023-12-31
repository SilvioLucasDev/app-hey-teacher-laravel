<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to open a question to edit', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = get(route('question.edit', $question));

    //Assert :: Verificar
    $request->assertSuccessful();
});

it('should return a view', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $request = get(route('question.edit', $question));

    //Assert :: Verificar
    $request->assertViewIs('question.edit');
});

it('should make sure that only question with status DRAFT can be edited', function () {
    // Arrange :: Preparar
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->create(['created_by' => $user->id, 'draft' => false]);
    $draftQuestion    = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);
    actingAs($user);

    // Act :: Agir
    $requestNotDraft = get(route('question.edit', $questionNotDraft));

    $requestDraft = get(route('question.edit', $draftQuestion));

    //Assert :: Verificar
    $requestNotDraft->assertForbidden();
    $requestDraft->assertSuccessful();
});

it('should make sure that only the person who has created the question can edit the question', function () {
    // Arrange :: Preparar
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $rightUser->id, 'draft' => true]);
    actingAs($wrongUser);

    // Act :: Agir
    $requestRightUser = get(route('question.edit', $question));

    //Assert :: Verificar
    $requestRightUser->assertForbidden();

    // Arrange :: Preparar
    actingAs($rightUser);

    // Act :: Agir
    $requestWrongUser = get(route('question.edit', $question));

    //Assert :: Verificar
    $requestWrongUser->assertSuccessful();
});
