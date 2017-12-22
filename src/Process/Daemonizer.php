<?php
declare(strict_types=1);

namespace Sokil\Worker\Process;

class Daemonizer
{
    /**
     * unlink from console
     *
     * @return int|null The forked PHP process ID, or false on error.
     */
    public function daemonize(): ?int
    {
        $pid = pcntl_fork();
        if($pid > 0) {
            // pid of child process in main process
            return null;
        } else if($pid < 0) {
            // error forking
            return null;
        }

        // set fork as main
        posix_setsid();

        // set user and group id
        if (!empty($uid)) {
            posix_setuid($uid);
        }

        if (!empty($gid)) {
            posix_setgid($gid);
        }

        // get pid of forked process
        $pid = getmypid();

        return $pid !== false ? $pid : null;
    }
}