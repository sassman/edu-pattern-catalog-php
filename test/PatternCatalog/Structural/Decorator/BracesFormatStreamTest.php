<?php

namespace PatternCatalog\Structural\Decorator;

/**
 * @group unit
 */
class BracesFormatStreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OutputStream
     */
    private $out;
    /**
     * @var MemoryOutputStream
     */
    private $memory;

    public function test_printf_withNoParameterNoHarm()
    {
        $this->out->printf('Foo Bar {0}');
        $this->assertThat($this->getMemory(), $this->equalTo('Foo Bar {0}'));
    }

    public function test_printf_willNowSupportBraces()
    {
        $this->out->printf('Foo Bar {0}', 'Bak');
        $this->assertThat($this->getMemory(), $this->equalTo('Foo Bar Bak'));
    }

    public function test_printf_stillSupportsPrintfNotation()
    {
        $this->out->printf('Foo Bar %s', 'Bak');
        $this->assertThat($this->getMemory(), $this->equalTo('Foo Bar Bak'));
    }

    public function test_printf_supportsPrintfNotationAndBraces()
    {
        $this->out->printf('Foo Bar {0}, %s', 'Bak');
        $this->assertThat($this->getMemory(), $this->equalTo('Foo Bar Bak, Bak'));
    }

    public function test_println_supportsPrintfNotationAndBraces()
    {
        $this->out->println('Foo Bar {0}, %s', 'Bak');
        $this->assertThat($this->getMemory(), $this->equalTo("Foo Bar Bak, Bak\n"));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->memory = new MemoryOutputStream();
        $this->out = new BracesFormatStream($this->memory);
    }

    /**
     * @return string
     */
    private function getMemory()
    {
        return $this->memory->getMemory();
    }
}
