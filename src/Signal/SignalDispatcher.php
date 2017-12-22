<?php
declare(strict_types=1);

namespace Sokil\Worker\Signal;

/**
 * Listen to signals and call related handlers
 */
class SignalDispatcher implements SignalDispatcherInterface
{
    /**
     * @var array
     */
    private $signalListeners = [];

    public function __construct()
    {
        for ($signal = 1; $signal <= 31; $signal++) {
            if (in_array($signal, SignalNumber::UNBLOCABLE_SIGNALS)) {
                // SIGKILL/SIGSTOP not allowed to be redefined
                continue;
            }

            pcntl_signal($signal, [$this, 'callSignalHandlers']);
        }
    }

    /**
     * @param int $signal
     * @param callable $listener
     */
    public function addListener(int $signal, $listener): void
    {
        if (!is_callable($listener)) {
            throw new \InvalidArgumentException('Listener must be callable');
        }

        $this->signalListeners[$signal][] = $listener;
    }

    /**
     * @param int $signal
     * @param callable $listener
     */
    public function removeListener(int $signal, $listener): void
    {
        if (empty($this->signalListeners[$signal])) {
            return;
        }

        $position = array_search($listener, $this->signalListeners[$signal]);

        if ($position !== false) {
            unset ($this->signalListeners[$signal][$position]);
        }
    }

    /**
     * @param int $signal
     */
    private function callSignalHandlers(int $signal)
    {
        if (empty($this->signalListeners[$signal])) {
            return;
        }

        foreach ($this->signalListeners[$signal] as $signalListener) {
            call_user_func($signalListener, $signal);
        }
    }

    /**
     * Calls signal handlers for pending signals
     */
    public function dispatchSignals(): void
    {
        pcntl_signal_dispatch();
    }


}
