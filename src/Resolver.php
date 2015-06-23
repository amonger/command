<?php

namespace Command;

class Resolver implements ResolverInterface
{
    /**
     * @param string $dto
     *
     * @return string
     */
    public function resolve($dto)
    {
        $segments = explode('\\', $dto);
        $class = $this->renameCommandAsHandler(array_pop($segments));
        $namespace = $this->renameCommandAsHandler(array_pop($segments));

        $segments[] = $namespace;
        $segments[] = $class;

        return implode('\\', $segments);
    }

    /**
     * @param $string
     * @return mixed
     */
    private function renameCommandAsHandler($string)
    {
        return str_replace('Command', 'Handler', $string);
    }
}
