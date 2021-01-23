<?php

namespace Unit\Tests\Services;

use App\Services\PalindromeService;
use PHPUnit\Framework\TestCase;

class PalindromeServiceTest extends TestCase
{
    private PalindromeService $service;

    public function setUp(): void
    {
        $this->service = new PalindromeService();
    }

    /**
     * @dataProvider palindromeProvider
     */
    public function testIsPalindrome(string $text, bool $expected): void
    {
        $this->assertSame($expected, $this->service->isPalindrome($text));
    }

    public function palindromeProvider(): array
    {
        return [
            ['', false],
            ['a', true],
            ['aa', true],
            ['ab', false],
            ['aba', true],
            ['abc', false],
            ['abba', true],
        ];
    }
}
