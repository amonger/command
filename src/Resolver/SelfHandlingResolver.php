<?php

namespace Command\Resolver;

/**
 * This returns the same class name so the handle method is run on the command object
 *
 * Class SelfHandlingResolver
 */
class SelfHandlingResolver implements ResolverInterface
{
    /**
     * @param string $dto
     *
     * @return string
     */
    public function resolve($dto)
    {
        return $dto;
    }
}
