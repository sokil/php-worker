<?php

use Sokil\Worker\Loop\Loop;
use Sokil\Worker\Loop\LoopTickInterface;
use Sokil\Worker\Signal\SignalDispatcher;
use Sokil\Worker\Process\ForkManager;

include __DIR__ . '/../vendor/autoload.php';

// fork
$forkManager = new ForkManager();
$forkManager->daemonize(function() {
    echo 'Parent process exited' . PHP_EOL;
});

// loop
$loop = new Loop(new SignalDispatcher());
$loop->run(new class implements LoopTickInterface {
    public function execute()
    {
        echo '.';
        sleep(1);
    }
});