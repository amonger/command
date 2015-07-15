<?php

use Command\Contracts\SelfHandlingInterface;
use Command\Resolver\SelfHandlingResolver;

class CommandTest extends PHPUnit_Framework_TestCase
{
    public function testPostVariablesAutomaticallyResolved()
    {
        $_POST = array('a_really-long_variable-name' => 'alan');
        $command = new Command\Command(new SelfHandlingResolver());
        $this->assertEquals('alan', $command->dispatch('CommandStubTwo'));
    }
}

class CommandStubTwo implements SelfHandlingInterface
{
    private $aReallyLongVariableName;

    public function __construct($aReallyLongVariableName)
    {
        $this->aReallyLongVariableName = $aReallyLongVariableName;
    }

    public function handle()
    {
        return $this->aReallyLongVariableName;
    }
}
