<?php

namespace PatternCatalog\Structural\Decorator;

/**
 * @group unit
 */
class MemoryOutputStreamTest extends \PHPUnit_Framework_TestCase
{
    public function test_getMemory_withParameters()
    {
        $stream = new MemoryOutputStream();
        $stream->println('foo bar %s', 'Bak');

        $this->assertThat($stream->getMemory(), $this->equalTo("foo bar Bak\n"));
        $stream->println('foo %s', 'Bak');

        $this->assertThat($stream->getMemory(), $this->equalTo("foo bar Bak\nfoo Bak\n"));
    }
}
