<?php

namespace Tests\Feature\V1\Admin\Question;

use App\Tbuy\Question\Models\Question;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{

    /**
     * Test the index method to get a list of all questions and answers.
     *
     * @return void
     */
    public function test_index()
    {
        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->get('api/v1/admin/question')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "message",
                "data" => []
            ])->assertJson([
                "success" => "true",
                "message" => "Список всех вопросов и ответов",
                "data" => []
            ]);
    }

    /**
     * Test the store method to create a new question and answer.
     *
     * @return void
     */
    public function test_store()
    {
        /** @var User $user */
        $user = User::query()->first();

        $question = Question::factory()->raw();

        $questionId = $this->actingAs($user)->postJson('api/v1/admin/question', $question)->assertStatus(200)->assertJsonStructure([
            "success",
            "message",
            "data" => [
                "id",
                "question",
                "answer"
            ]
        ])->json('data.id');

        $this->assertDatabaseHas('questions', [
            'id' => $questionId
        ]);

    }

    /**
     * Test the update method to update a question and answer.
     *
     * @return void
     */
    public function test_update()
    {
        /** @var User $user */
        $user = User::query()->first();
        $this->actingAs($user);

        $question = Question::query()->inRandomOrder()->first();
        $newQuestion = Question::factory()->raw();

        $response = $this->putJson('api/v1/admin/question/'.$question->id, $newQuestion);


        $response->assertStatus(200);

        $response->assertJsonStructure([
            "success",
            "message",
            "data" => [
                "id",
                "question",
                "answer"
            ]
        ]);

        $this->assertEquals(json_encode([
            'success' => true,
            'message' => 'Вопрос и ответ успешно обновлены',
            'data' => [
                'id' => $question->id,
                'question' => $newQuestion['question']['ru'],
                'answer' => $newQuestion['answer']['ru']
            ]
        ]), json_encode($response->json()));
    }

    /**
     * Test the destroy method to delete a question and answer.
     *
     * @return void
     */

    public function testDestroy()
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $this->actingAs($user);

        $question = Question::create([
            'question' => 'Sample question in Russian',
            'answer' => 'Sample answer in Russian'
        ]);

        $response = $this->delete('api/v1/admin/question/' . $question->id);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Вопрос и ответ удалены',
        ]);

        $this->assertSoftDeleted('questions', ['id' => $question->id]);
    }
}
