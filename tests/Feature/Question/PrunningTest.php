<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, artisan, assertDatabaseMissing};

it('should prune records deleted more than 1 month', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true, 'deleted_at' => now()->subMonth(2)]);
    actingAs($user);

    // Act :: Agir
    artisan('model:prune');

    //Assert :: Verificar
    assertDatabaseMissing('questions', ['id' => $question->id]);
});
