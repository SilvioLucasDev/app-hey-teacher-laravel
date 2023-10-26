<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    // Arrange :: Preparar
    $user      = User::factory()->create();
    $questions = Question::factory()->count(5)->create();
    actingAs($user);

    // Act :: Agir
    $response = get(route('dashboard'));

    //Assert :: Verificar
    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});

test('should paginate the result', function () {
    // Arrange :: Preparar
    $user = User::factory()->create();
    Question::factory()->count(20)->create();
    actingAs($user);

    // Act :: Agir
    $response = get(route('dashboard'));

    //Assert :: Verificar
    $response->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});
