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
        $percent = 0;
        similar_text($a, $b, $percent);

        $distance = levenshtein($a, $b);
        $relative = $distance / max(strlen($a), strlen($b), 1);

        return $percent >= 85 || $relative <= 0.15;
    }
}
