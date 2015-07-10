<?php

use Command\Contracts\ApplicationInterface;
use Command\Contracts\SelfHandling;
use Command\Resolver\SelfHandlingResolver;
use Mockery as m;

class SelfHandlingResolverTest extends PHPUnit_Framework_TestCase
{
    private $selfHandlingResolver;

    public function setup()
    {
        $this->selfHandlingResolver = new SelfHandlingResolver();
    }

    public function testHandleCommandReturnsSameObjectThatWasPassed()
    {
        $commandClass = new CommandStub(4);
        $handlerClass = $this->selfHandlingResolver->resolve($commandClass);
        $this->assertEquals($commandClass, $handlerClass);
    }

    public function testCallableIsExecutedInHandlerMethod()
    {
        $resolver = new SelfHandlingResolver();
        $resolver->setApplication(function ($a) {
            return $a * 2;
        });

        $command = new Command\Command($resolver);
        $this->assertEquals(4, $command->dispatch(new CommandStub(2)));
    }
}

class CommandStub implements SelfHandling, ApplicationInterface
{
    private $number;
    private $application;

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function handle()
    {
        $app = $this->application;
        return $app($this->number);
    }

    /**
     * @param $application
     * @return void
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }
}
