<?php
declare(strict_types=1);

namespace Sokil\Worker\Signal;

/**
 * Listen to signals and call related handlers
 */
class SignalDispatcher implements SignalDispatcherInterface
{
    public const SIGHUP = 1;
    public const SIGINT = 2;
    public const SIGQUIT = 3;
    public const SIGILL = 4;
    public const SIGTRAP = 5;
    public const SIGABRT = 6;
    public const SIGIOT = 6;
    public const SIGBUS = 7;
    public const SIGFPE = 8;
    public const SIGKILL = 9;
    public const SIGUSR1 = 10;
    public const SIGSEGV = 11;
    public const SIGUSR2 = 12;
    public const SIGPIPE = 13;
    public const SIGALRM = 14;
    public const SIGTERM = 15;
    public const SIGSTKFLT = 16;
    public const SIGCLD = 17;
    public const SIGCHLD = 17;
    public const SIGCONT = 18;
    public const SIGSTOP = 19;
    public const SIGTSTP = 20;
    public const SIGTTIN = 21;
    public const SIGTTOU = 22;
    public const SIGURG = 23;
    public const SIGXCPU = 24;
    public const SIGXFSZ = 25;
    public const SIGVTALRM = 26;
    public const SIGPROF = 27;
    public const SIGWINCH = 28;
    public const SIGPOLL = 29;
    public const SIGIO = 29;
    public const SIGPWR = 30;
    public const SIGSYS = 31;
    public const SIGBABY = 31;

    /**
     * @var array
     */
    private $signalListeners = [];

    public function __construct()
    {
        for ($signal = 1; $signal <= 31; $signal++) {
            if (in_array($signal, [self::SIGKILL, self::SIGSTOP])) {
                // SIGKILL/SIGSTOP not allowed to be redefined
                continue;
            }

            pcntl_signal($signal, [$this, 'dispatchSignal']);
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
    private function dispatchSignal(int $signal)
    {
        if (empty($this->signalListeners[$signal])) {
            return;
        }

        foreach ($this->signalListeners[$signal] as $signalListener) {
            call_user_func($signalListener, $signal);
        }
    }
}
