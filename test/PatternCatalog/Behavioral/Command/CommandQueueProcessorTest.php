<?php

namespace PatternCatalog\Behavioral\Command;

use PHPUnit_Framework_TestCase;

/**
 * @group unit
 */
class CommandQueueProcessorTest extends PHPUnit_Framework_TestCase
{
    public function test_execution_withSingleCommands_runsThru()
    {
        $queue = new CommandQueueProcessor();
        $queue->pushOne($this->createConcreteCommand());
        $queue->pushOne($this->createConcreteCommand());

        $queue->execute();
    }

    /**
     * @return Command
     */
    private function createConcreteCommand()
    {
        $command = $this->createMock(Command::class);
        $command->expects($this->once())->method('execute');

        return $command;
    }
}
