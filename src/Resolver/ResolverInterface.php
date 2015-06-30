<?php

namespace Command\Resolver;

interface ResolverInterface
{
    /**
     * @param string $dto
     */
    public function resolve($dto);
}