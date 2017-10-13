<?php

namespace PatternCatalog\Structural\Decorator;

// TODO fix that inclusion
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InterceptedTestCase.php';

/**
 * @group unit
 */
class FileOutputStreamTest extends InterceptedTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_constructor_withNonSupportedArgument()
    {
        new FileOutputStream(4.5);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_constructor_withNonFileWillThrow()
    {
        new FileOutputStream('/tmp');
    }

    public function test_printf_withoutAnyArguments()
    {
        $this->out->printf('Foo Bar Bak');
        $this->assertThat($this->getMemory(), $this->equalTo("Foo Bar Bak"));
    }

    public function test_printf_withSomeArguments()
    {
        $this->out->printf('Foo Bar %s', 'Bak');
        $this->assertThat($this->getMemory(), $this->equalTo("Foo Bar Bak"));
    }

    public function test_println_withSomeArguments()
    {
        $this->out->println('Foo Bar %s', 'Bak');
        $this->assertThat($this->getMemory(), $this->equalTo("Foo Bar Bak\n"));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->out = new FileOutputStream($this->memory);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->out = null;
    }
}
