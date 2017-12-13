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
     * @param callable $handler
     */
    public function attachHandler(int $signal, callable $handler): void;
}
