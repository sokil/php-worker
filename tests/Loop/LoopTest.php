<?php
declare(strict_types=1);

namespace Sokil\Worker;

use PHPUnit\Framework\TestCase;
use Sokil\Worker\Loop\Loop;
use Sokil\Worker\Signal\SignalDispatcherInterface;
use Sokil\Worker\Loop\LoopTickInterface;

class LoopTest extends TestCase
{
    public function testRun()
    {
        $loopInterruptionSignals = [
            SIGINT,
            SIGTERM,
            SIGHUP,
            SIGUSR1,
        ];

        // do one tick and exit
        /** @var LoopTickInterface $tick */
        $tick = $this->createMock(LoopTickInterface::class);
        $tick
            ->expects($this->once())
            ->method('execute')
            ->willReturn(false);

        // signal dispatcher
        /** @var SignalDispatcherInterface $signalDispatcher */
        $signalDispatcher = $this->createMock(SignalDispatcherInterface::class);
        $signalDispatcher
            ->expects($this->exactly(count($loopInterruptionSignals)))
            ->method('addListener');
        $signalDispatcher
            ->expects($this->exactly(count($loopInterruptionSignals)))
            ->method('removeListener');

        // test loop
        $loop = new Loop($signalDispatcher, $loopInterruptionSignals);
        $loop->run($tick);
    }
}