<?php

namespace Command\Contracts;

interface SelfHandling
{
    /**
     * @return mixed
     */
    public function handle();
}
