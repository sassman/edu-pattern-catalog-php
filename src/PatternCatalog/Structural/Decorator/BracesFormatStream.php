<?php

namespace PatternCatalog\Structural\Decorator;

/**
 * here we see a so called Decorator Pattern. It is implementing the OutputStream interface, therefore it is itself
 * a OutputStream and as you can see in the Constructor it accepts a OutputStream instance itself.
 *
 * So it does something on top of of the other OutputStream is doing.
 * Therefore it is decorating the OutputStream passed in the constructor.
 */
class BracesFormatStream implements OutputStream
{
    /**
     * @var OutputStream
     */
    private $stream;

    /**
     * @param OutputStream $stream the decorated instance
     */
    public function __construct(OutputStream $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @see https://docs.python.org/3.4/library/string.html#formatstrings
     * Note: The positional argument specifiers can NOT be omitted
     *
     * @param string $string supports now braces as formatter like println("my cool string {0} and {1}", "a", "b")
     * @param array ...$parameter
     * @return void
     */
    public function println($string, ...$parameter)
    {
        $this->stream->println($this->handleBraces($string, ...$parameter), ...$parameter);
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function printf($string, ...$parameter)
    {
        $this->stream->printf($this->handleBraces($string, ...$parameter), ...$parameter);
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return string
     */
    private function handleBraces($string, ...$parameter)
    {
        $keys = array_map(function ($key) {
            return '{' . $key . '}';
        }, array_keys($parameter));

        return strtr($string, array_combine($keys, array_values($parameter)));
    }
}