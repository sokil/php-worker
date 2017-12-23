<?php
declare(strict_types=1);

namespace Sokil\Worker\Process\Exception;

use Throwable;

/**
 * POSIX errors
 */
class PosixException extends ProcessException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        // prepare message
        $posixErrorMessage = posix_strerror(posix_get_last_error());
        $message = empty($message)
            ? $posixErrorMessage
            : $message . ' (' . $posixErrorMessage . ')';

        // prepare code
        if (empty($code)) {
            $code = posix_get_last_error();
        }

        parent::__construct($message, $code, $previous);
    }
}