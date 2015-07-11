<?php

namespace Command\Contracts;

interface ResolverInterface
{
    /**
     * @param ApplicationInterface $dto
     * @return mixed
     */
    public function resolve($dto);

    /**
     * @param $application
     *
     * @return void
     */
    public function setApplication($application);
}
