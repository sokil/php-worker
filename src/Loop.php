<?php
declare(strict_types=1);

namespace Sokil\Worker;

use Sokil\Worker\Signal\SignalDispatcherInterface;
use Sokil\Worker\Tick\TickInterface;

class Loop
{
    /**
     * @var bool
     */
    private $isLoopInterrupted = false;

    /**
     * @var SignalDispatcherInterface
     */
    private $signalDispatcher;

    /**
     * @var array
     */
    private $loopInterruptionSignals = [
        SIGINT, // Ctrl+C in console
        SIGTERM, // Graceful termination by supervisor
        SIGHUP,
        SIGUSR1,
    ];

    /**
     * @param SignalDispatcherInterface $signalDispatcher
     * @param array|null $loopInterruptionSignals
     */
    public function __construct(
        SignalDispatcherInterface $signalDispatcher,
        array $loopInterruptionSignals = null
    ) {
        $this->signalDispatcher = $signalDispatcher;

        // add signal handlers to stop loop
        if ($loopInterruptionSignals !== null) {
            $this->loopInterruptionSignals = $loopInterruptionSignals;
        }
    }

    /**
     * Add loop interruption handler for passed signals
     */
    private function attachLoopInterruptionSignalHandler(): void
    {
        foreach ($this->loopInterruptionSignals as $loopInterruptionSignal) {
            $this->signalDispatcher->attachHandler(
                $loopInterruptionSignal,
                function() {
                    $this->isLoopInterrupted = true;
                }
            );
        }
    }

    public function attachSignalHandler(int $signal, callable $handler): void
    {
        $this->signalDispatcher->attachHandler($signal, $handler);
    }

    /**
     * @param TickInterface $tick
     */
    public function run(TickInterface $tick)
    {
        $this->attachLoopInterruptionSignalHandler();

        while (!$this->isLoopInterrupted) {
            $tick->execute();
        }
    }
}
