<?php

namespace Tests\Feature;

use App\Constants\ReviewerVisibilityConstant;
use App\Models\Reviewer;
use App\Models\User;
use Tests\TestCase;

class ReviewerFeatureTest extends TestCase
{

    private string $resource = '/api/reviewers';

    /**
     * Get reviewer payload.
     *
     * @return array
     */
    private function getPayload(): array
    {
        return [
            'userId' => User::factory()->create()->id,
            'name' => fake()->text(),
            'visibility' => fake()->randomElement(ReviewerVisibilityConstant::asList()),
            'description' => fake()->text(),
            'coverImage' => fake()->imageUrl()
        ];
    }

    /**
     * @test
     *
     * A basic unit test in creating reviewer.
     *
     * @return void
     */
    public function testCreateReviewer(): void
    {
        $token = $this->loginSystemAdminUser();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->post($this->resource, $payload);

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in getting paginated reviewers.
     *
     * @return void
     */
    public function testGetPaginatedReviewers(): void
    {
        $token = $this->loginSystemAdminUser();
        Reviewer::factory()->count(15)->create();
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
     * A basic unit test in getting reviewer by id.
     *
     * @return void
     */
    public function testGetReviewerById(): void
    {
        $token = $this->loginSystemAdminUser();
        $reviewer = Reviewer::factory()->create();
        $response = $this->withToken($token)->get("{$this->resource}/{$reviewer->id}");

        $response->assertOk()->assertJson(['id' => $reviewer->id]);
    }

    /**
     * @test
     *
     * A basic unit test in updating reviewer.
     *
     * @return void
     */
    public function testUpdateReviewer(): void
    {
        $token = $this->loginSystemAdminUser();
        $reviewer = Reviewer::factory()->create();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->put("{$this->resource}/{$reviewer->id}", $payload);

        // For assertion
        $payload['id'] = $reviewer->id;

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in deleting reviewer.
     *
     * @return void
     */
    public function testDeleteReviewer(): void
    {
        $token = $this->loginSystemAdminUser();
        $reviewer = Reviewer::factory()->create();
        $response = $this->withToken($token)->delete("{$this->resource}/{$reviewer->id}");

        $response->assertOk()->assertJsonStructure(['success']);
    }

}
