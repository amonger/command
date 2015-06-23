#Command#

This is a simple command bus for use with PHP 5.3

## Use ##

```PHP
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
    namespace Command\Handler;

    class MyHandlerHandler implements HandlerInterface
    {
        public function handle($object)
        {
            echo $object->someParam;
        }
    }
```

```PHP
    $command = new Command\Command(new Command\Resolver);
    $command->dispatch(new MyHandlerCommand($someParam);
```

This will resolve MyHandlerHandler which implements HandlerInterface.
