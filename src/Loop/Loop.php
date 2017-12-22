<?php
declare(strict_types=1);

namespace Sokil\Worker\Loop;

use Sokil\Worker\Signal\SignalDispatcherInterface;

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
        SIGTERM, // Default graceful termination signal of supervisor
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
     * Stop iterating loop
     */
    public function interruptLoop()
    {
        $this->isLoopInterrupted = true;
    }

    /**
     * @param LoopTickInterface $tick
     */
    public function run(LoopTickInterface $tick)
    {
        // attach signal handlers to stop loop
        foreach ($this->loopInterruptionSignals as $loopInterruptionSignal) {
            $this->signalDispatcher->addListener(
                $loopInterruptionSignal,
                [$this, 'interruptLoop']
            );
        }

        // run loop
        while (!$this->isLoopInterrupted) {
            // execute tick
            $continueLoop = $tick->execute();

            // check if interruption required
            if ($continueLoop === false) {
                $this->interruptLoop();
            }
        }

        // detach signal handlers to stop loop
        foreach ($this->loopInterruptionSignals as $loopInterruptionSignal) {
            $this->signalDispatcher->removeListener(
                $loopInterruptionSignal,
                [$this, 'interruptLoop']
            );
        }
    }
}
