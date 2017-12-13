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
    private $signalHandlers = [];

    public function __construct()
    {
        for ($signal = 0; $signal <=32; $signal++) {
            pcntl_signal($signal, [$this, 'dispatchSignal']);
        }
    }

    /**
     * @param int $signal
     * @param callable $handler
     */
    public function attachHandler(int $signal, callable $handler): void
    {
        $this->signalHandlers[$signal][] = $handler;
    }

    /**
     * @param int $signal
     */
    private function dispatchSignal(int $signal)
    {
        if (empty($this->signalHandlers[$signal])) {
            return;
        }

        foreach ($this->signalHandlers[$signal] as $signalHandler) {
            call_user_func($signalHandler, $signal);
        }
    }
}
