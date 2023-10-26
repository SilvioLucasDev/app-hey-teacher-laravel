<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('should be able to list all question created by me', function () {
    $wrongUser      = User::factory()->create();
    $wrongQuestions = Question::factory(10)->create(['created_by' => $wrongUser->id]);
    $rightUser      = User::factory()->create();
    $rightQuestions = Question::factory(10)->create(['created_by' => $rightUser->id]);
    actingAs($rightUser);

    // Act :: Agir
    $response = get(route('question.index'));

    //Assert :: Verificar
    /** @var Question $q */
    foreach ($rightQuestions as $q) {
        $response->assertSee($q->question);
    }

    /** @var Question $q */
    foreach ($wrongQuestions as $q) {
        $response->assertDontSee($q->question);
    }
});
