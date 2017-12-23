<?php
declare(strict_types=1);

namespace Sokil\Worker\Process;

use Sokil\Worker\Process\Exception\PosixException;
use Sokil\Worker\Signal\SignalNumber;
use Sokil\Worker\Process\Exception\ProcessControl\ForkErrorException;

/**
 * Managing processes
 */
class ForkManager
{
    /**
     * @return int|null The forked PHP process ID in master process or 0 in child process
     *
     * @throws ForkErrorException when process non forked
     */
    public function fork(): int
    {
        $pid = pcntl_fork();

        // pid of child process in parent process
        if($pid > 0) {
            return $pid;
        }

        // fork error
        if($pid === -1) {
            throw new ForkErrorException();
        }

        return 0;
    }

    /**
     * Unlink process from console
     *
     * @param callable $onBeforeExit Executed before exit of parent process. Gets PID of child process as argument
     *
     * @throws ForkErrorException
     */
    public function daemonize(callable $onBeforeExit): void
    {
        $pid = $this->fork();

        if ($pid > 0) {
            // parent process, required exit
            call_user_func($onBeforeExit, $pid);
            exit();
        }

        // set fork as main
        $sessionId = posix_setsid();
        if ($sessionId === -1) {
            throw new PosixException('Error making the current process a session leader');
        }
    }

    /**
     * Check if process with passed pid is alive
     *
     * @param int $pid
     * @return bool
     */
    private function isProcessAlive(int $pid) : bool
    {
        return posix_kill($pid, SignalNumber::SIGCHLD);
    }

    /**
     * @param int $uid
     *
     * @throws PosixException
     */
    private function setCurrentProcessUid(int $uid): void
    {
        if (posix_setuid($uid) === false) {
            throw new PosixException('Error setting current process UID');
        }
    }

    /**
     * @param int $gid
     *
     * @throws PosixException
     */
    private function setCurrentProcessGid(int $gid): void
    {
        if (posix_setgid($gid) === false) {
            throw new PosixException('Error setting current process GID');
        }
    }

    /**
     * @return int
     */
    private function getCurrentProcessId(): int
    {
        return posix_getpid();
    }
}