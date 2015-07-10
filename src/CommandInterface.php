<?php

namespace Command;

use Command\Contracts\ApplicationInterface;

/**
 * A simple command pattern implementation for dispatching commands
 *
 * Class Command
 */
interface CommandInterface
{
    /**
     * Object is a simple data transport object. The DTO class path is
     * captured, and the last two segments of the path are renamed to
     * handler which is then passed the DTO.
     *
     * @param ApplicationInterface $object
     * @return mixed
     */
    public function dispatch($object);
}
