[![Build Status](https://travis-ci.org/amonger/command.svg?branch=master)](https://travis-ci.org/amonger/command)
#Command#

This is a simple command bus for use with PHP 5.3

## Use ##

```PHP
<?php
    namespace Command\Command;

    class MyHandlerCommand
    {
        public $someParam;

        public function __construct($someParam)
        {
            $this->someParam = $someParam;
        }
    }
```

```PHP
<?php
    namespace Command\Handler;

    class MyHandlerHandler implements HandlerInterface, ApplicationInterface
    {
        protected $app;
        
        public function handle($object)
        {
            echo $app['db']->persist($object->someParam);
        }
        
        public function setApplication($app)
        {
            $this->app = $app;
        }
    }
```

```PHP
    $command = new Command\Command(new Command\Resolver);
    $command->setApplication($app);
    $command->dispatch(new MyHandlerCommand($someParam));
```

This will resolve MyHandlerHandler which implements HandlerInterface, and 
provides access to your application container.

## Self handling ##

Alternatively you might not want to separate your DTOs from your commands. In this case, you can
just implement the self handling interface which will call the handle method.

```PHP
<?php
namespace Command\Command;
    
class MyHandlerCommand implements SelfHandling
{
    protected $someParam;

    public function __construct($someParam)
    {
        $this->someParam = $someParam;
    }
         
    public function handle()
    {
        return $this->someParam * 2;
    }
}
```

Finally, you can get access to the application by implementing ApplicationInterface
```PHP
<?php
class TestCommand implements SelfHandling, ApplicationInterface
{
    private $name;
    private $application;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function handle()
    {
        $app = $this->application;
        var_dump($app($this->name));
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
```
```PHP
    $resolver = new \Command\Resolver\SelfHandlingResolver();
    $resolver->setApplication(function($a){ return $a*2;});

    $command = new Command\Command($resolver);
    $command->dispatch(new TestCommand(2));
```
