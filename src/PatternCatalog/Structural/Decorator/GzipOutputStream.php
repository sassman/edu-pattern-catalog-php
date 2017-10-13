<?php

namespace PatternCatalog\Structural\Decorator;

use PatternCatalog\Structural\Decorator\Formatter\PrintfStringFormatter;

class GzipOutputStream implements OutputStream
{
    use PrintfStringFormatter;

    /**
     * @var OutputStream
     */
    private $stream;

    /**
     * @param OutputStream $stream
     */
    public function __construct(OutputStream $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function println($string, ...$parameter)
    {
        $this->printf($string . PHP_EOL, ...$parameter);
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function printf($string, ...$parameter)
    {
        $this->stream->printf(
            $this->encode(
                $this->format($string, $parameter)
            )
        );
    }

    /**
     * @param string $string
     * @return string
     */
    private function encode($string)
    {
        return gzencode($string);
    }
}