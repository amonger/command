<?php

namespace Command\Resolver;

use Command\Contracts\ApplicationInterface;
use Command\Contracts\ResolverInterface;

/**
 * This returns the same class name so the handle method is run on the command object
 *
 * Class SelfHandlingResolver
 */
class SelfHandlingResolver implements ResolverInterface, ApplicationInterface
{
    private $application = null;

    /**
     * @param ApplicationInterface $dto
     *
     * @return object
     */
    public function resolve($dto)
    {
        if ($dto instanceof ApplicationInterface) {
            $dto->setApplication($this->application);
        }

        return $dto;
    }

    /**
     * @param $application
     *
     * @return void
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }
}
