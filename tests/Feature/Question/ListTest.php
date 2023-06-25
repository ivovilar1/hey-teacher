<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    // Arrange - create some questions
    $user      = User::factory()->create();
    $questions = Question::factory()->count(5)->create();
    actingAs($user);
    // act - acess to route
    $response = get(route('dashboard'));
    // Assert - verifiy if a list of questions its show
    /** @var Question $q */
    foreach($questions as $q) {
        $response->assertSee($q->question);
    }
});

it('should paginate the result', function () {
    $user = User::factory()->create();
    Question::factory()->count(20)->create();
    actingAs($user);
    get(route('dashboard'))->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});

it('should order by like and unlike, most liked question should be at the top, most unliked question shoul be at the bottom', function () {
    $user       = User::factory()->create();
    $secondUser = User::factory()->create();
    Question::factory()->count(5)->create();
    $mostLikedQuestion   = Question::inRandomOrder()->first();
    $mostUnlikedQuestion = Question::inRandomOrder()->first();
    $user->like($mostLikedQuestion);
    $secondUser->unlike($mostUnlikedQuestion);
    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) use ($mostLikedQuestion, $mostUnlikedQuestion) {
            expect($questions)
                ->first()->id->toBe($mostLikedQuestion->id)
                ->and($questions)
                ->last()->id->toBe($mostUnlikedQuestion->id);

            return true;
        });
});
