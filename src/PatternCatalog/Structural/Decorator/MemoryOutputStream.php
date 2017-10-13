<?php

namespace PatternCatalog\Structural\Decorator;

class MemoryOutputStream extends FileOutputStream
{
    public function __construct()
    {
        parent::__construct('php://memory');
    }

    /**
     * @return string the whole memory
     */
    public function getMemory()
    {
        $pos = ftell($this->getHandle());
        fseek($this->getHandle(), 0);
        $buffer = stream_get_contents($this->getHandle());
        fseek($this->getHandle(), $pos);

        return $buffer;
    }
}