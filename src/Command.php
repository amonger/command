<?php

namespace Command;

use Command\Contracts\ResolverInterface;
use ReflectionClass;

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
     * If it is a string generate a new object and use post vars to
     * attempt to construct the new object
     *
     * @param string|object $object
     * @return object
     */
    public function dispatch($object)
    {
        if (is_string($object)) {
            return $this->dispatch($this->populateObjectFromPost($object));
        }
        $handlerObject = $this->resolver->resolve($object);

        return call_user_func(array($handlerObject, 'handle'), $object);
    }

    /**
     * Use reflection to get the class constructor values, and map each one to
     * a POST variable.
     *
     * @param string $object
     *
     * @return object
     */
    public function populateObjectFromPost($object)
    {
        $reflectionClass = new ReflectionClass($object);
        $parameters = $reflectionClass->getConstructor()->getParameters();
        $postVars = $this->normalise($_POST);
        array_walk($parameters, function (&$value) use ($postVars) {
            $value = $postVars[$value->name];
        });

        return $reflectionClass->newInstanceArgs($parameters);
    }

    /**
     * Convert post variables to camelcase
     *
     * @param array $variables
     *
     * @return array
     */
    private function normalise($variables)
    {
        $parameters = array();
        foreach ($variables as $key => $value) {
            $newKey = $this->convertToCamelCase($key, array('-', '_'));
            $parameters[$newKey] = $value;
        }

        return $parameters;
    }

    /**
     * Iterate through the deliminators and convert to camelcase when a pattern matches
     *
     * @param string $string
     * @param array|string $deliminator
     *
     * @return string
     */
    private function convertToCamelCase($string, $deliminator)
    {
        if (is_array($deliminator)) {
            $currentDeliminator = array_pop($deliminator);
            if (count($deliminator) > 0) {
                $string = $this->convertToCamelCase($string, $deliminator);
            }
            return $this->convertToCamelCase($string, $currentDeliminator);
        }

        return lcfirst(implode('', array_map(function ($chunk) {
            return ucfirst($chunk);
        }, explode($deliminator, $string))));
    }
}
