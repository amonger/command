<?php

namespace Command;

/**
 * A simple command pattern implementation for dispatching commands
 *
 * Class Command
 */
class Command
{
    private $resolver;
    private $container;

    /**
     * @param ResolverInterface $resolver
     * @param null $container
     */
    public function __construct(ResolverInterface $resolver, $container = null)
    {
        $this->resolver = $resolver;
        $this->container = $container;
    }

    /**
     * Object is a simple data transport object. The DTO class path is
     * captured, and the last two segments of the path are renamed to
     * handler which is then passed the DTO.
     *
     * @param $object
     * @return mixed
     */
    public function dispatch($object)
    {
        $handler = $this->resolver->resolve(get_class($object));
        $handlerObject = new $handler($this->container);

        return call_user_func(array($handlerObject, 'handle'), $object);
    }
}
