<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\Reviewer;
use Tests\TestCase;

class NoteFeatureTest extends TestCase
{

    private string $resource = '/api/notes';

    /**
     * Get note payload.
     *
     * @return array
     */
    private function getPayload(): array
    {
        return [
            'reviewerId' => Reviewer::factory()->create()->id,
            'title' => fake()->sentence(),
            'content' => fake()->paragraph()
        ];
    }

    /**
     * @test
     *
     * A basic unit test in creating note.
     *
     * @return void
     */
    public function testCreateNote(): void
    {
        $token = $this->loginSystemAdminUser();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->post($this->resource, $payload);

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in getting paginated notes.
     *
     * @return void
     */
    public function testGetPaginatedNotes(): void
    {
        $token = $this->loginSystemAdminUser();
        Note::factory()->count(15)->create();
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
     * A basic unit test in getting note by id.
     *
     * @return void
     */
    public function testGetNoteById(): void
    {
        $token = $this->loginSystemAdminUser();
        $note = Note::factory()->create();
        $response = $this->withToken($token)->get("{$this->resource}/{$note->id}");

        $response->assertOk()->assertJson(['id' => $note->id]);
    }

    /**
     * @test
     *
     * A basic unit test in updating note.
     *
     * @return void
     */
    public function testUpdateNote(): void
    {
        $token = $this->loginSystemAdminUser();
        $note = Note::factory()->create();
        $payload = $this->getPayload();
        $response = $this->withToken($token)->put("{$this->resource}/{$note->id}", $payload);

        // For assertion
        $payload['id'] = $note->id;

        $response->assertOk()->assertJson($payload);
    }

    /**
     * @test
     *
     * A basic unit test in deleting note.
     *
     * @return void
     */
    public function testDeleteNote(): void
    {
        $token = $this->loginSystemAdminUser();
        $note = Note::factory()->create();
        $response = $this->withToken($token)->delete("{$this->resource}/{$note->id}");

        $response->assertOk()->assertJsonStructure(['success']);
    }

}
