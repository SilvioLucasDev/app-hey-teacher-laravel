<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()->count(5)->create();

    // Act :: Agir
    $response = get(route('dashboard'));

    //Assert :: Verificar
    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});
