<?php

namespace Command\Contracts;

interface SelfHandlingInterface
{
    /**
     * @return mixed
     */
    public function handle();
}
