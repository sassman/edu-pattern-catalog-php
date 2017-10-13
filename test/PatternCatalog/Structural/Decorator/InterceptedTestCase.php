<?php

namespace PatternCatalog\Structural\Decorator;

use php_user_filter;

class Sniffer extends php_user_filter
{
    public static $sniffed = '';

    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$sniffed .= $bucket->data;
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_PASS_ON;
    }
}

class InterceptedTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var resource */
    protected $memory;
    /** @var OutputStream */
    protected $out;

    protected function setUp()
    {
        $this->memory = fopen('php://memory', 'w');
        $this->setUpInterceptor();
    }

    /**
     * @return string
     */
    protected function getMemory()
    {
        return Sniffer::$sniffed;
    }

    private function setUpInterceptor()
    {
        Sniffer::$sniffed = '';
        stream_filter_register("sniffer", '\\PatternCatalog\\Structural\\Decorator\\Sniffer');
        stream_filter_append($this->memory, "sniffer");
    }
}
