<?php


namespace Command;


interface ResolverInterface
{
    /**
     * @param string $dto
     */
    public function resolve($dto);
}