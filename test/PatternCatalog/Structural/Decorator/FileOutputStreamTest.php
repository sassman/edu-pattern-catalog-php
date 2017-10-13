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

/**
 * @group unit
 */
class FileOutputStreamTest extends \PHPUnit_Framework_TestCase
{
    /** @var resource */
    private $memory;
    /** @var FileOutputStream */
    private $out;

    public function test_printf_withoutAnyArguments()
    {
        $this->out->printf('Foo Bar Bak');
        $this->assertThat(Sniffer::$sniffed, $this->equalTo("Foo Bar Bak"));
    }

    public function test_printf_withSomeArguments()
    {
        $this->out->printf('Foo Bar %s', 'Bak');
        $this->assertThat(Sniffer::$sniffed, $this->equalTo("Foo Bar Bak"));
    }

    public function test_println_withSomeArguments()
    {
        $this->out->println('Foo Bar %s', 'Bak');
        $this->assertThat(Sniffer::$sniffed, $this->equalTo("Foo Bar Bak\n"));
    }

    protected function setUp()
    {
        $this->memory = fopen('php://memory', 'w');
        $this->out = new FileOutputStream($this->memory);
        $this->setUpInterceptor();
    }

    private function setUpInterceptor()
    {
        Sniffer::$sniffed = '';
        stream_filter_register("sniffer", '\\PatternCatalog\\Structural\\Decorator\\Sniffer');
        stream_filter_append($this->memory, "sniffer");
    }
}
