<?php

namespace Abeliani\SlugHelper;

class SlugHelper
{
    const TO_LOWER = 0;
    const TO_UPPER = 1;

    public function __construct(
        private array  $removedWordsList = [],
        private string $insteadOfSpaces = '-',
        private bool   $nonSlugChars = true,
        private int    $toCase = self::TO_LOWER,
    ) {
    }

    public static function convert(string $string, array $clearWords = []): string
    {
        return (new self($clearWords))->__invoke($string);
    }

    public function process(string $text): string
    {
        return $this->__invoke($text);
    }

    public function __invoke(string $text): string
    {
        if (!$text) {
            return $text;
        }

        return $this->replaceSpaces($this->removeWordsByList($this->filterNonSlugChars($text)));
    }

    private function filterNonSlugChars(string $text): string
    {
        if ($this->nonSlugChars) {
           return preg_replace('~[^\w\s]~u', '', $text);
        }

        return $text;
    }

    private function removeWordsByList(string $text): string
    {
        if ($this->removedWordsList) {
            $pattern = sprintf('~(%s)([^\w]|$)~ui', implode('|', $this->removedWordsList));
            $text = preg_replace($pattern, '', $text);
        }

        return $text;
    }

    private function replaceSpaces(string $text): string
    {
        return preg_replace('~\s+~', $this->insteadOfSpaces, trim($this->stringCase($text)));
    }

    private function stringCase(string $text): string
    {
        return match ($this->toCase) {
            self::TO_LOWER => mb_strtolower($text),
            self::TO_UPPER => mb_strtoupper($text),
            default => $text,
        };
    }
}
