<?php

namespace Tests\Feature;

use App\Models\Question;
use Tests\TestCase;

class QuestionFeatureTest extends TestCase
{

    private string $resource = '/api/questions';

    /**
     * Get question payload.
     *
     * @return array
     */
    private function getPayload(): array
    {
        return [
            // Add the request payload here
        ];
    }

    /**
     * @test
     *
     * A basic unit test in creating question.
     *
     * @return void
     */
    public function testCreateQuestion(): void
    {
        $token = $this->loginSystemAdminUser();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->post($this->resource, $payload);

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in getting paginated questions.
     *
     * @return void
     */
    public function testGetPaginatedQuestions(): void
    {
        $token = $this->loginSystemAdminUser();
        Question::factory()->count(15)->create();
        $response = $this->withToken($token)->get($this->resource);

        $response->assertOk()->assertJsonStructure(['data', 'links', 'meta']);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $links = $response->json('links');
        $this->assertIsArray($links);
        $this->assertNotEmpty($links);

        $meta = $response->json('meta');
        $this->assertIsArray($meta);
        $this->assertNotEmpty($meta);
    }

    /**
     * @test
     *
     * A basic unit test in getting question by id.
     *
     * @return void
     */
    public function testGetQuestionById(): void
    {
        $token = $this->loginSystemAdminUser();
        $question = Question::factory()->create();
        $response = $this->withToken($token)->get("{$this->resource}/{$question->id}");

        $response->assertOk()->assertJson(['id' => $question->id]);
    }

    /**
     * @test
     *
     * A basic unit test in updating question.
     *
     * @return void
     */
    public function testUpdateQuestion(): void
    {
        $token = $this->loginSystemAdminUser();
        $question = Question::factory()->create();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->put("{$this->resource}/{$question->id}", $payload);

        // For assertion
        $payload['id'] = $question->id;

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in deleting question.
     *
     * @return void
     */
    public function testDeleteQuestion(): void
    {
        $token = $this->loginSystemAdminUser();
        $question = Question::factory()->create();
        $response = $this->withToken($token)->delete("{$this->resource}/{$question->id}");

        $response->assertOk()->assertJsonStructure(['success']);
    }

}
