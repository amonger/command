<?php

namespace Command\Resolver;

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
    /**
     * @param string $dto
     *
     * @return string
     */
    public function resolve($dto)
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
}
