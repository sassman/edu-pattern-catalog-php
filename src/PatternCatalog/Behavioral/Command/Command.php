<?php

namespace PatternCatalog\Behavioral\Command;

/**
 * a small simple command to execute
 *
 * @link https://en.wikipedia.org/wiki/Command_pattern
 */
interface Command
{
    /**
     * @return mixed|void
     */
    public function execute();
}
