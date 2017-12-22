<?php

use Sokil\Worker\Loop\Loop;
use Sokil\Worker\Loop\LoopTickInterface;
use Sokil\Worker\Signal\SignalDispatcher;

include __DIR__ . '/../vendor/autoload.php';

$loop = new Loop(new SignalDispatcher());
$loop->run(new class implements LoopTickInterface {
    public function execute()
    {
        echo '.';
        sleep(1);
    }
});