<?php

namespace App\Services;

class PalindromeService
{
    public function isPalindrome(string $text): bool
    {
        if ($text === '') {
            return false;
        }

        $numberOfCharacters = strlen($text);
        $stopCondition = ceil($numberOfCharacters / 2);
        for ($i = 0; $i < $stopCondition; ++$i) {
            if ($text[$i] !== $text[$numberOfCharacters - 1 - $i]) {
                return false;
            }
        }

        return true;
    }
}
