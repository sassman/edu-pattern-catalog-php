<?php

namespace PatternCatalog\Structural\Decorator;

class BroadcastOutputStream implements OutputStream
{
    /**
     * @var OutputStream[]
     */
    private $receivers;

    public function __construct(OutputStream ...$receivers)
    {
        $this->receivers = $receivers;
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function println($string, ...$parameter)
    {
        foreach ($this->receivers as $receiver) {
            $receiver->println($string, ...$parameter);
        }
    }

    /**
     * @param string $string
     * @param array ...$parameter
     * @return void
     */
    public function printf($string, ...$parameter)
    {
        foreach ($this->receivers as $receiver) {
            $receiver->printf($string, ...$parameter);
        }
    }
}