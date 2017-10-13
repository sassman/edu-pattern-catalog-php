<?php

namespace PatternCatalog\Structural\Decorator;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'InterceptedTestCase.php';

/**
 * @group unit
 */
class ShiftCipherOutputStreamTest extends InterceptedTestCase
{
    public function test_print_WillShiftByN()
    {
        $this->out->printf('This is Caesar!');
        $this->assertThat($this->getMemory(), $this->equalTo('Guvf vf Pnrfne!'));
    }

    public function test_println_WillShiftByN()
    {
        $this->out->println('This is Caesar!');
        $this->assertThat($this->getMemory(), $this->equalTo("Guvf vf Pnrfne!\n"));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->out = new ShiftCipherOutputStream(new FileOutputStream($this->memory));
    }
}
