<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it('should be able to like a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    // Act :: Agir
    post(route('question.like', $question->id))
        ->assertRedirect();

    //Assert :: Verificar
    assertDatabaseHas('votes', [
        'like'    => 1,
        'unlike'  => 0,
        'user_id' => $user->id,
    ]);
});

it('should not be able to like more than 1 time', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    // Act :: Agir
    post(route('question.like', $question->id));
    post(route('question.like', $question->id));
    post(route('question.like', $question->id));
    post(route('question.like', $question->id));

    //Assert :: Verificar
    expect($user->votes()->where('question_id', '=', $question->id)->get())->toHaveCount(1);
});

it('should be able to unlike a question', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    // Act :: Agir
    post(route('question.unlike', $question->id))
        ->assertRedirect();

    //Assert :: Verificar
    assertDatabaseHas('votes', [
        'like'    => 0,
        'unlike'  => 1,
        'user_id' => $user->id,
    ]);
});

it('should not be able to unlike more than 1 time', function () {
    // Arrange :: Preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    // Act :: Agir
    post(route('question.unlike', $question->id));
    post(route('question.unlike', $question->id));
    post(route('question.unlike', $question->id));
    post(route('question.unlike', $question->id));

    //Assert :: Verificar
    expect($user->votes()->where('question_id', '=', $question->id)->get())->toHaveCount(1);
});
