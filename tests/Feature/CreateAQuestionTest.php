<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it('should be able to create a new question bigger than 255 characters', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 255) . '?',
    ]);

    //Assert :: Verificar
    $request->assertRedirect(route('dashboard'));
    assertDatabaseHas('questions', ['question' => str_repeat('*', 255) . '?']);
});

it('should check if ends with question mark ?', function () {
    expect(true)->toBeTrue();
})->todo();

it('should have at least 10 characters', function () {
    expect(true)->toBeTrue();
})->todo();
