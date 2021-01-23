<?php

namespace App\Http\Controllers;

use App\Models\Palindrome;
use App\Services\PalindromeService;
use Illuminate\Http\Request;

class PalindromeController extends Controller
{
    private PalindromeService $palindromeService;

    public function __construct(PalindromeService $palindromeService)
    {
        $this->palindromeService = $palindromeService;
    }

    public function index(Request $request)
    {
        // Allow users to paginate up to 100 entries per page
        $perPage = min(100, (int)$request->get('per_page', 10));
        $palindromes = $this->palindromeService->getPalindromes($perPage);
        return response()->json($palindromes);
    }

    public function store(Request $request)
    {
        $text = $request->get('text');

        $palindrome = $this->palindromeService->get($text);

        if ($palindrome) {
            return response()->json(['message' => 'Palindrome entry already exists'], 400);
        }

        $palindrome = $this->palindromeService->add($text);

        return response()->json(['result' => $palindrome->is_palindrome], 201);
    }

    public function show(string $text, Request $request)
    {
        $palindrome = $this->palindromeService->get($text);
        if ( ! $palindrome) {
            return response()->json(['message' => 'Palindrome entry does not exist'], 404);
        }

        return response()->json(['result' => $palindrome->is_palindrome]);
    }

    public function update($text, Request $request)
    {
        $palindrome = $this->palindromeService->get($text);
        if ( ! $palindrome) {
            return response()->json(['message' => 'Palindrome entry does not exist'], 404);
        }

        $palindrome = $this->palindromeService->update($palindrome, $request->get('text'));

        return response()->json(['result' => $palindrome->is_palindrome]);
    }

    public function destroy(string $text)
    {
        if ( ! $this->palindromeService->remove($text)) {
            return response()->json(['message' => 'Palindrome entry does not exist'], 404);
        }

        return response()->json(['result' => true]);
    }
}
