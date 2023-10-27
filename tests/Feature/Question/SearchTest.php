<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('should be able to search a question by text', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    Question::factory()->create(['question' => 'My question is?']);
    Question::factory()->create(['question' => 'Something else?']);
    actingAs($user);

    // Act :: Agir
    $response = get(route('dashboard', ['search' => 'question']));

    //Assert :: Verificar
    $response->assertDontSee('Something else?');
    $response->assertSee('My question is?');
});
