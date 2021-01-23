<?php

namespace App\Services;

use App\Models\Palindrome;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PalindromeService
{
    /**
     * Determines whether the provided text is a palindrome.
     * An empty string is not considered a palindrome.
     */
    public function isPalindrome(string $text): bool
    {
        if ($text === '') {
            return false;
        }

        $numberOfCharacters = strlen($text);
        $stopCondition = floor($numberOfCharacters / 2);
        for ($i = 0; $i < $stopCondition; ++$i) {
            if ($text[$i] !== $text[$numberOfCharacters - 1 - $i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Fetches a collection of entries from the palindrome table (may or may not be palindromes).
     */
    public function getPalindromes(int $perPage): LengthAwarePaginator
    {
        $palindromes = Palindrome::paginate($perPage);
        return $palindromes;
    }

    /**
     * Fetch and return an entry from the palindromes table.
     */
    public function get(string $text): ?Palindrome
    {
        return Palindrome::where('text', '=', $text)->first();
    }

    /**
     * Add a palindrome entry to the palindromes table. Returns the newly created palindrome entry.
     */
    public function add(string $text): ?Palindrome
    {
        $palindrome = Palindrome::create([
            'text' => $text,
            'is_palindrome' => $this->isPalindrome($text),
        ]);
        return $palindrome;
    }

    /**
     * Update a palindrome model with a new text. If an existing palindrome entry with the provided
     * text exists, we will remove the one provided for update and return the existing one.
     */
    public function update(Palindrome $palindrome, string $text): Palindrome
    {
        $existingPalindrome = $this->get($text);
        if ($existingPalindrome) {
            // New palindrome is already in DB, let's return it after deleting the existing one
            $this->remove($text);
            return $existingPalindrome;
        }

        $palindrome->text = $text;
        $palindrome->is_palindrome = $this->isPalindrome($text);

        $palindrome->save();

        return $palindrome;
    }

    /**
     * Remove a palindrome entry from the palindromes table if it exists, otherwise returns false.
     */
    public function remove(string $text): bool
    {
        $palindrome = $this->get($text);
        if ( ! $palindrome) {
            return false;
        }

        $palindrome->delete();

        return true;
    }
}
