<?php


class ResolverTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->resolver = new Command\Resolver;
    }

    public function testResolverResolvesHandler()
    {
        $resolved = $this->resolver->resolve('\\App\\Command\\TestCommand');
        $this->assertEquals('\\App\\Handler\\TestHandler', $resolved);
    }
}
