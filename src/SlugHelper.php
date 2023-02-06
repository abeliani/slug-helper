<?php

namespace Abeliani\SlugHelper;

class SlugHelper
{
    const TO_LOWER = 0;
    const TO_UPPER = 1;

    public function __construct(
        private array  $clearWords = [],
        private string $insteadOfSpaces = '-',
        private bool   $onlyWords = true,
        private int    $toCase = self::TO_LOWER,
    ) {
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

        if ($this->onlyWords) {
            $text = preg_replace('~[^\w\s]~u', '', $text);
        }

        if ($this->clearWords) {
            $pattern = sprintf('~(%s)([^\w]|$)~ui', implode('|', $this->clearWords));
            $text = preg_replace($pattern, '', $text);
        }

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
