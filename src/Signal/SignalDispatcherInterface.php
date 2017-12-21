<?php
declare(strict_types=1);

namespace Sokil\Worker\Signal;

/**
 * Listen to signals and call related handlers
 */
interface SignalDispatcherInterface
{
    /**
     * @param int $signal
     * @param callable $listener
     */
    public function addListener(int $signal, $listener): void;

    /**
     * @param int $signal
     * @param callable $listener
     */
    public function removeListener(int $signal, $listener): void;
}
