<?php

namespace PatternCatalog\Structural\Decorator;

use PatternCatalog\Structural\Decorator\Formatter\PrintfStringFormatter;

/**
 * naive ASCII based ShiftCipher implementation
 */
class ShiftCipherOutputStream implements OutputStream
{
    use PrintfStringFormatter;

    const MAX_ALPHABET_LETTERS = 26;

    /**
     * @var OutputStream
     */
    private $stream;
    /**
     * @var int
     */
    private $shiftBy;

    public function __construct(OutputStream $stream, $shiftBy = 13)
    {
        $this->stream = $stream;
        $this->shiftBy = $shiftBy % self::MAX_ALPHABET_LETTERS;
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function println($string, ...$parameter)
    {
        $this->stream->println($this->encode($this->format($string, $parameter)));
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function printf($string, ...$parameter)
    {
        $this->stream->printf($this->encode($this->format($string, $parameter)));
    }

    /**
     * @param string $string
     * @return string
     */
    private function encode($string)
    {
        return implode('',
            array_map(
                function ($letter) {
                    return $this->encodeChar($letter);
                },
                str_split($string)
            )
        );
    }

    /**
     * @param string $letter
     * @return string
     */
    private function encodeChar($letter)
    {
        $indexInAsciiTable = ord($letter);
        $range = $indexInAsciiTable <= 90 ? 65 : 97;
        $indexInAsciiTable -= $range;
        $isNoLetter = $indexInAsciiTable >= self::MAX_ALPHABET_LETTERS || $indexInAsciiTable < 0;
        if ($isNoLetter) {
            return $letter;
        }
        $indexInAsciiTable += $this->shiftBy;
        $indexInAsciiTable %= self::MAX_ALPHABET_LETTERS;
        $indexInAsciiTable += $range;

        return chr($indexInAsciiTable);
    }
}