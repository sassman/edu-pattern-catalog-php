<?php

namespace PatternCatalog\Structural\Decorator;

class FileOutputStream implements OutputStream
{
    /**
     * @var resource
     */
    private $handle;

    /**
     * @param string|resource $fileUrlOrHandle
     */
    public function __construct($fileUrlOrHandle)
    {
        if (is_string($fileUrlOrHandle)) {
            $this->handle = \fopen($fileUrlOrHandle, 'w');
        } else {
            if (is_resource($fileUrlOrHandle)) {
                $this->handle = $fileUrlOrHandle;
            } else {
                throw new \UnexpectedValueException('argument should be string or resource');
            }
        }
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
        \fwrite($this->handle, vsprintf($string, $parameter));
    }
}