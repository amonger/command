<?php

namespace Command;
use Command\Contracts\ResolverInterface;


/**
 * A simple command pattern implementation for dispatching commands
 *
 * Class Command
 */
class Command
{
    private $resolver;

    /**
     * @param ResolverInterface $resolver
     */
    public function __construct(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Object is a simple data transport object. The DTO class path is
     * captured, and the last two segments of the path are renamed to
     * handler which is then passed the DTO.
     *
     * @param ApplicationInterface $object
     * @return mixed
     */
    public function dispatch($object)
    {
        $handlerObject = $this->resolver->resolve($object);

        return call_user_func(array($handlerObject, 'handle'), $object);
    }
}
