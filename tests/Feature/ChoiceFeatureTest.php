<?php

namespace Tests\Feature;

use App\Models\Choice;
use Tests\TestCase;

class ChoiceFeatureTest extends TestCase
{

    private string $resource = '/api/choices';

    /**
     * Get choice payload.
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
     * A basic unit test in creating choice.
     *
     * @return void
     */
    public function testCreateChoice(): void
    {
        $token = $this->loginSystemAdminUser();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->post($this->resource, $payload);

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in getting paginated choices.
     *
     * @return void
     */
    public function testGetPaginatedChoices(): void
    {
        $token = $this->loginSystemAdminUser();
        Choice::factory()->count(15)->create();
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
     * A basic unit test in getting choice by id.
     *
     * @return void
     */
    public function testGetChoiceById(): void
    {
        $token = $this->loginSystemAdminUser();
        $choice = Choice::factory()->create();
        $response = $this->withToken($token)->get("{$this->resource}/{$choice->id}");

        $response->assertOk()->assertJson(['id' => $choice->id]);
    }

    /**
     * @test
     *
     * A basic unit test in updating choice.
     *
     * @return void
     */
    public function testUpdateChoice(): void
    {
        $token = $this->loginSystemAdminUser();
        $choice = Choice::factory()->create();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->put("{$this->resource}/{$choice->id}", $payload);

        // For assertion
        $payload['id'] = $choice->id;

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in deleting choice.
     *
     * @return void
     */
    public function testDeleteChoice(): void
    {
        $token = $this->loginSystemAdminUser();
        $choice = Choice::factory()->create();
        $response = $this->withToken($token)->delete("{$this->resource}/{$choice->id}");

        $response->assertOk()->assertJsonStructure(['success']);
    }

}
