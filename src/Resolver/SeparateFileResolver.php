<?php

namespace Command\Resolver;

use Command\Contracts\ApplicationInterface;

/**
 * This maps the command object to a handler by rewriting the parent namespace
 * and the command ending from "command" to "handler".
 *
 * So:                      App\Command\MyCommand
 * would be resolved by:    App\Handler\MyHandler
 *
 * Class SeparateFileResolver
 */
class SeparateFileResolver implements ResolverInterface
{
    private $application = null;

    public function resolve($object)
    {
        $className = $this->getClassName(get_class($object));

        $handler = new $className;
        if ($object instanceof ApplicationInterface) {
            $object->setApplication($this->application);
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
     * @return mixed
     */
    private function renameAsHandler($string)
    {
        return str_replace('Command', 'Handler', $string);
    }

    /**
     * @param null $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }
}
