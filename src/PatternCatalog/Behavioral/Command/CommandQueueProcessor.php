<?php

namespace PatternCatalog\Behavioral\Command;

use InvalidArgumentException;

class CommandQueueProcessor implements Command
{
    /**
     * @var Command[]
     */
    private $queue = [];

    /**
     * @param Command[] $queue
     * @throws InvalidArgumentException
     */
    public function __construct($queue = [])
    {
        $this->addCommands($queue);
    }

    /**
     * @param Command $command
     */
    public function pushOne(Command $command)
    {
        $this->queue[] = $command;
    }

    /**
     * @param Command[] $commands
     * @throws InvalidArgumentException
     */
    public function pushMany($commands)
    {
        $this->addCommands($commands);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        foreach ($this->queue as $command) {
            $command->execute();
        }
    }

    /**
     * @param Command[] $commands
     */
    private function addCommands($commands)
    {
        if (!is_array($commands)) {
            throw new InvalidArgumentException(Command::class . ' array is expected.');
        }
        foreach ($commands as $command) {
            if (!$command instanceof Command) {
                throw new InvalidArgumentException('instance needs to be an ' . Command::class);
            }
            $this->queue[] = $command;
        }
    }
}