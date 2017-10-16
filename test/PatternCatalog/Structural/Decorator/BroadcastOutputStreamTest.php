<?php

namespace PatternCatalog\Structural\Decorator;

/**
 * @group unit
 */
class BroadcastOutputStreamTest extends \PHPUnit_Framework_TestCase
{
    public function test_println_IsBroadcastToAll()
    {
        $out = new BroadcastOutputStream(...$this->getStreams('println'));
        $out->println('Foo Bar %s', 'Bak');
    }

    public function test_printf_IsBroadcastToAll()
    {
        $out = new BroadcastOutputStream(...$this->getStreams('printf'));
        $out->printf('Foo Bar %s', 'Bak');
    }

    /**
     * @param string $methodName
     * @param int $howMany
     * @return OutputStream[]
     */
    private function getStreams($methodName, $howMany = 2)
    {
        $streamBuilder = $this->getMockBuilder(OutputStream::class);
        $streams = [];

        while (--$howMany >= 0) {
            $stream = $streamBuilder->getMockForAbstractClass();
            $stream->expects($this->once())->method($methodName)
                ->with($this->equalTo('Foo Bar %s'), $this->equalTo('Bak'));
            $streams[] = $stream;
        }

        return $streams;
    }
}