<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class SimilarProductName implements ValidationRule
{
    public function __construct(private readonly ?int $ignoreId = null) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $incoming = $this->normalize((string) $value);

        $names = Product::query()
            ->when($this->ignoreId, fn ($query) => $query->whereKeyNot($this->ignoreId))
            ->pluck('name');

        foreach ($names as $existing) {
            $normalized = $this->normalize((string) $existing);

            if ($normalized === '' || $incoming === '') {
                continue;
            }

            if ($normalized === $incoming || $this->isTooSimilar($incoming, $normalized)) {
                $fail("Ya existe un producto con un nombre demasiado similar: \"{$existing}\".");

                return;
            }
        }
    }

    /**
     * Normaliza removiendo acentos, caracteres no alfabéticos y plural simple.
     */
    private function normalize(string $value): string
    {
        $text = Str::of($value)
            ->lower()
            ->squish()
            ->ascii();

        $text = preg_replace('/[^a-zñ ]/u', ' ', (string) $text);
        $words = array_filter(explode(' ', $text));

        $words = array_map(function (string $word) {
            if (strlen($word) <= 3) {
                return $word;
            }

            return preg_replace('/(es|s)$/u', '', $word);
        }, $words);

        return implode(' ', $words);
    }

    private function isTooSimilar(string $a, string $b): bool
    {
        if ($this->differsOnlyByAllowedGradeSuffix($a, $b)) {
            return false;
        }

        $percent = 0;
        similar_text($a, $b, $percent);

        $distance = levenshtein($a, $b);
        $relative = $distance / max(strlen($a), strlen($b), 1);

        return $percent >= 85 || $relative <= 0.15;
    }

    private function differsOnlyByAllowedGradeSuffix(string $a, string $b): bool
    {
        $tokensA = array_values(array_filter(explode(' ', $a)));
        $tokensB = array_values(array_filter(explode(' ', $b)));

        if (count($tokensA) < 2 || count($tokensB) < 2) {
            return false;
        }

        if (count($tokensA) !== count($tokensB)) {
            return false;
        }

        $baseA = array_slice($tokensA, 0, -1);
        $baseB = array_slice($tokensB, 0, -1);
        if ($baseA !== $baseB) {
            return false;
        }

        $suffixA = $tokensA[count($tokensA) - 1];
        $suffixB = $tokensB[count($tokensB) - 1];

        if ($suffixA === $suffixB) {
            return false;
        }

        return $this->isAllowedGradeToken($suffixA) && $this->isAllowedGradeToken($suffixB);
    }

    private function isAllowedGradeToken(string $token): bool
    {
        $token = trim($token);
        if ($token === '') {
            return false;
        }

        if (preg_match('/^([a-z])\\1{0,4}$/', $token) === 1) {
            return true;
        }

        return in_array($token, ['xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl'], true);
    }
}
