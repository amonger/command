<?php

namespace Command;

interface HandlerInterface
{
    /**
     * @param $class
     * @return mixed
     */
    public function handle($class);
}
