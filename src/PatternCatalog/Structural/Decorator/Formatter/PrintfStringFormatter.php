<?php

namespace PatternCatalog\Structural\Decorator\Formatter;

trait PrintfStringFormatter
{
    /**
     * @param string $string
     * @param array $parameter
     * @return string
     */
    protected function format($string, $parameter)
    {
        return vsprintf($string, $parameter);
    }
}