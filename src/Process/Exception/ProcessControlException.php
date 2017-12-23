<?php
declare(strict_types=1);

namespace Sokil\Worker\Process\Exception;

use Throwable;

/**
 * PCNTL errors
 */
class ProcessControlException extends ProcessException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        // prepare message
        $posixErrorMessage = pcntl_strerror(pcntl_get_last_error());
        $message = empty($message)
            ? $posixErrorMessage
            : $message . ' (' . $posixErrorMessage . ')';

        // prepare code
        if (empty($code)) {
            $code = pcntl_get_last_error();
        }

        parent::__construct($message, $code, $previous);
    }
}