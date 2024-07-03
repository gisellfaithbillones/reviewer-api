<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use Tests\TestCase;

class AnswerFeatureTest extends TestCase
{

    private string $resource = '/api/answers';

    /**
     * Get answer payload.
     *
     * @return array
     */
    private function getPayload(): array
    {
        return [
            'questionId' => Question::factory()->create()->id,
            'content' => fake()->sentence()
        ];
    }

    /**
     * @test
     *
     * A basic unit test in creating answer.
     *
     * @return void
     */
    public function testCreateAnswer(): void
    {
        $token = $this->loginSystemAdminUser();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->post($this->resource, $payload);

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in getting paginated answers.
     *
     * @return void
     */
    public function testGetPaginatedAnswers(): void
    {
        $token = $this->loginSystemAdminUser();
        Answer::factory()->count(15)->create();
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
     * A basic unit test in getting answer by id.
     *
     * @return void
     */
    public function testGetAnswerById(): void
    {
        $token = $this->loginSystemAdminUser();
        $answer = Answer::factory()->create();
        $response = $this->withToken($token)->get("{$this->resource}/{$answer->id}");

        $response->assertOk()->assertJson(['id' => $answer->id]);
    }

    /**
     * @test
     *
     * A basic unit test in updating answer.
     *
     * @return void
     */
    public function testUpdateAnswer(): void
    {
        $token = $this->loginSystemAdminUser();
        $answer = Answer::factory()->create();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->put("{$this->resource}/{$answer->id}", $payload);

        // For assertion
        $payload['id'] = $answer->id;

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in deleting answer.
     *
     * @return void
     */
    public function testDeleteAnswer(): void
    {
        $token = $this->loginSystemAdminUser();
        $answer = Answer::factory()->create();
        $response = $this->withToken($token)->delete("{$this->resource}/{$answer->id}");

        $response->assertOk()->assertJsonStructure(['success']);
    }

}
