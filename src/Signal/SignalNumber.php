<?php
declare(strict_types=1);

namespace Sokil\Worker\Signal;

/**
 * @see /usr/include/bits/signum.h
 * @see https://en.wikipedia.org/wiki/Signal_(IPC)
 */
class SignalNumber
{
    /**
     * Hangup (POSIX)
     * The SIGHUP signal is sent to a process when its controlling terminal is closed.
     * It was originally designed to notify the process of a serial line drop (a hangup).
     * In modern systems, this signal usually means that the controlling pseudo or virtual terminal has been closed.
     * Many daemons will reload their configuration files and reopen their logfiles instead of exiting when receiving
     * this signal.
     */
    public const SIGHUP = 1;
    
    /**
     * Interrupt (ANSI)
     * Ctrl+C in console
     */
    public const SIGINT = 2;
    
    /**
     * Quit (POSIX)
     * By default, this causes the process to terminate and dump core.
     * Ctrl-\ in console
     */
    public const SIGQUIT = 3;

    public const SIGILL = 4;

    public const SIGTRAP = 5;

    public const SIGABRT = 6;

    public const SIGIOT = 6;

    public const SIGBUS = 7;

    public const SIGFPE = 8;
    
    /**
     * Kill (POSIX)
     * Unblockable
     */
    public const SIGKILL = 9;

    public const SIGUSR1 = 10;

    public const SIGSEGV = 11;

    public const SIGUSR2 = 12;

    public const SIGPIPE = 13;

    public const SIGALRM = 14;

    /**
     * Termination (ANSI)
     * The SIGTERM signal is sent to a process to request its termination.
     * Unlike the SIGKILL signal, it can be caught and interpreted or ignored by the process.
     * This allows the process to perform nice termination releasing resources and saving state if appropriate.
     * SIGINT is nearly identical to SIGTERM.
     * Default graceful termination of process by supervisor.
     */
    public const SIGTERM = 15;

    public const SIGSTKFLT = 16;

    /**
     * Child status has changed (POSIX)
     * The SIGCHLD signal is sent to a process when a child process terminates, is interrupted,
     * or resumes after being interrupted. One common usage of the signal is to instruct the operating system to clean
     * up the resources used by a child process after its termination without an explicit call to the wait system call.
     */
    public const SIGCHLD = 17;
    public const SIGCLD = 17;

    public const SIGCONT = 18;
    
    /**
     * Stop (POSIX)
     * Unblockable
     */
    public const SIGSTOP = 19;
    
    /**
     * Keyboard stop (POSIX)
     * By default, this causes the process to suspend execution.
     * Use 'fg' to resume it in the foreground, and make it the current job.
     * Ctrl-Z in console
     */
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
     * @return int[]
     */
    public const UNBLOCABLE_SIGNALS = [
        self::SIGKILL, 
        self::SIGSTOP,   
    ];
}
