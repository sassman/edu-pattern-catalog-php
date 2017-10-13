<?php

namespace PatternCatalog\Structural\Decorator;

use PHPUnit_Framework_Constraint;

/**
 * @group integration
 */
class GzipOutputStreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MemoryOutputStream
     */
    private $memory;
    /**
     * @var OutputStream
     */
    private $out;

    public function test_println_willCreateValidGzipFile()
    {
        $this->out->println('Foo Bar Bak');
        $this->assertThatGzipContentEquals("Foo Bar Bak\n");
    }

    public function test_println_withArguments()
    {
        $this->out->println('Foo Bar %s', 'Bak');
        $this->assertThatGzipContentEquals("Foo Bar Bak\n");
    }

    public function test_printf_withArguments()
    {
        $this->out->printf('Foo Bar %s', 'Bak');
        $this->assertThatGzipContentEquals('Foo Bar Bak');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->memory = new MemoryOutputStream();
        $this->out = new GzipOutputStream($this->memory);
    }

    /**
     * @param PHPUnit_Framework_Constraint $expectedToBe
     */
    private function assertThatGzipContent(PHPUnit_Framework_Constraint $expectedToBe)
    {
        $content = $this->memory->getMemory();
        $original = gzdecode($content);

        $this->assertThat($original, $expectedToBe);
    }

    /**
     * @param string $string
     */
    private function assertThatGzipContentEquals($string)
    {
        $this->assertThatGzipContent($this->equalTo($string));
    }
}