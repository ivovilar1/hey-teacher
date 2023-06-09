<?php
use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing,assertNotSoftDeleted, assertSoftDeleted, delete, patch};

it('it should be able archive a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);

    actingAs($user);

    patch(route('question.archive', $question))->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question)->refresh()->deleted_at->not->toBeNull();
});

it('should make sure that only the person who was created the question can archive the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()
        ->for(User::class, 'createdBy')
        ->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    patch(route('question.archive', $question))->assertForbidden();

    actingAs($rightUser);

    patch(route('question.archive', $question))->assertRedirect();
});

it('should be able to restore a archived question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id, 'deleted_at' => now()]);

    actingAs($user);

    patch(route('question.restore', $question))->assertRedirect();

    assertNotSoftDeleted('questions', ['id' => $question->id]);

    expect($question)->refresh()->deleted_at->toBeNull();
});
