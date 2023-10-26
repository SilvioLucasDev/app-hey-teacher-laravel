<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('should be able to create a new question bigger than 255 characters', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    //Assert :: Verificar
    $request->assertRedirect(route('dashboard'));
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should create a new question as a draft', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route('question.store'), ['question' => str_repeat('*', 260) . '?',
    ]);

    //Assert :: Verificar
    $request->assertRedirect(route('dashboard'));
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
        'draft'    => true,
    ]);
});

it('should check if ends with question mark "?"', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    //Assert :: Verificar
    $request->assertSessionHasErrors(['question' => 'Are you sure that is a question? It is missing the question mark in the end.']);
    assertDatabaseCount('questions', 0);
});

it('should have at least 10 characters when creating a new question', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert :: Verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

it('only authenticated user can create a new question', function () {
    // Act :: Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert :: Verificar
    $request->assertRedirect(route('login'));
});
