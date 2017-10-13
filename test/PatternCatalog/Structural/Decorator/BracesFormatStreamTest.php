<?php

namespace PatternCatalog\Structural\Decorator;

// TODO fix that inclusion
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InterceptedTestCase.php';

/**
 * @group unit
 */
class BracesFormatStreamTest extends InterceptedTestCase
{
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
        $this->out = new BracesFormatStream(new FileOutputStream($this->memory));
    }
}
