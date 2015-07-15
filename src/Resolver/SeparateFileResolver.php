<?php

namespace Command\Resolver;

use Command\Contracts\ApplicationInterface;
use Command\Contracts\ResolverInterface;

/**
 * This maps the command object to a handler by rewriting the parent namespace
 * and the command ending from "command" to "handler".
 *
 * So:                      App\Command\MyCommand
 * would be resolved by:    App\Handler\MyHandler
 *
 * Class SeparateFileResolver
 */
class SeparateFileResolver implements ResolverInterface, ApplicationInterface
{
    private $application = null;

    /**
     * @param ApplicationInterface $object
     *
     * @return object
     */
    public function resolve($object)
    {
        $className = $this->getClassName(get_class($object));

        $handler = new $className;
        if ($handler instanceof ApplicationInterface) {
            $handler->setApplication($this->application);
        }

        return $handler;
    }

    /**
     * @param string $dto
     *
     * @return string
     */
    public function getClassName($dto)
    {
        $segments = explode('\\', $dto);
        $class = $this->renameAsHandler(array_pop($segments));
        $namespace = $this->renameAsHandler(array_pop($segments));

        $segments[] = $namespace;
        $segments[] = $class;

        return implode('\\', $segments);
    }

    /**
     * @param $string
     *
     * @return string
     */
    private function renameAsHandler($string)
    {
        return str_replace('Command', 'Handler', $string);
    }

    /**
     * @param mixed $application
     *
     * @return void
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }
}
