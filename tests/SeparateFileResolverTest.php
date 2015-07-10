<?php

class SeparateFileResolverTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->resolver = new Command\Resolver\SeparateFileResolver;
    }

    public function testResolverResolvesHandler()
    {
        $resolved = $this->resolver->getClassName('\\App\\Command\\TestCommand');
        $this->assertEquals('\\App\\Handler\\TestHandler', $resolved);
    }
}
