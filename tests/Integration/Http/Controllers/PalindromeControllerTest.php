<?php

namespace Tests\Integration\Http\Controllers;

use App\Models\Palindrome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PalindromeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setupExistingPalindromes(): void
    {
        Palindrome::create(['text' => 'racecar', 'is_palindrome' => true]);
    }

    public function testIndex(): void
    {
        $this->setupExistingPalindromes();

        $response = $this->get('api/v1/palindromes');

        $response->assertStatus(200);
        $data = $response->json()['data'];
        $this->assertSame('racecar', $data[0]['text']);
        $this->assertSame(true, $data[0]['is_palindrome']);
    }

    public function testEmptyIndex(): void
    {
        $response = $this->get('api/v1/palindromes');

        $response->assertStatus(200);
        $this->assertEmpty($response->json()['data']);
    }

    public function testStore(): void
    {
        $response = $this->post('api/v1/palindromes', ['text' => 'racecar']);

        $response->assertStatus(201);
        // Verify palindrome was added to the database
        $palindrome = Palindrome::where('text', '=', 'racecar')->first();
        $this->assertSame('racecar', $palindrome->text);
        $this->assertSame(true, $palindrome->is_palindrome);
    }

    public function testStoreExistingPalindromeShouldReturn400(): void
    {
        $this->setupExistingPalindromes();

        $response = $this->post('api/v1/palindromes', ['text' => 'racecar']);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Palindrome entry already exists']);
    }

    public function testShow(): void
    {
        $this->setupExistingPalindromes();

        $response = $this->get('api/v1/palindromes/racecar');

        $response->assertStatus(200);
        $response->assertJson(['result' => true]);
    }

    public function testShowMissingPalindromeReturnsStatus404(): void
    {
        $response = $this->get('api/v1/palindromes/racecar');

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Palindrome entry does not exist']);
    }

    public function testUpdate(): void
    {
        $this->setupExistingPalindromes();

        $response = $this->patch('api/v1/palindromes/racecar', ['text' => 'not a palindrome']);

        $response->assertStatus(200);
        $response->assertJson(['result' => false]);
    }

    public function testUpdateMissingPalindromeShouldReturnStatus404(): void
    {
        $response = $this->patch('api/v1/palindromes/racecar', ['text' => 'not a palindrome']);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Palindrome entry does not exist']);
    }

    public function testDelete(): void
    {
        $this->setupExistingPalindromes();

        $response = $this->delete('api/v1/palindromes/racecar');

        $response->assertStatus(200);
    }

    public function testDeleteMissingPalindromeShouldReturnStatus404(): void
    {
        $response = $this->delete('api/v1/palindromes/racecar');

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Palindrome entry does not exist']);
    }
}
