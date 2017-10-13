<?php

namespace PatternCatalog\Structural\Decorator;

use PatternCatalog\Structural\Decorator\Formatter\PrintfStringFormatter;

class FileOutputStream implements OutputStream
{
    use PrintfStringFormatter;

    /**
     * @var resource
     */
    private $handle;

    /**
     * @param string|resource $fileUrlOrHandle
     * @throws \InvalidArgumentException
     */
    public function __construct($fileUrlOrHandle)
    {
        if (is_string($fileUrlOrHandle)) {
            if (is_dir($fileUrlOrHandle)) {
                throw new \InvalidArgumentException('directories are not supported.');
            }
            $fileUrlOrHandle = \fopen($fileUrlOrHandle, 'w');
        }
        if (!is_resource($fileUrlOrHandle)) {
            throw new \InvalidArgumentException('argument should be string or resource');
        }
        $this->handle = $fileUrlOrHandle;
    }

    /**
     * make sure resource is closed
     */
    public function __destruct()
    {
        \fclose($this->handle);
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
        \fwrite($this->handle, $this->format($string, $parameter));
    }

    /**
     * @return resource
     */
    protected function getHandle()
    {
        return $this->handle;
    }
}