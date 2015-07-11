<?php

namespace Command\Contracts;

interface HandlerInterface
{
    /**
     * @param $class
     * @return mixed
     */
    public function handle($class);
}
