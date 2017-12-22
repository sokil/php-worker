<?php
declare(strict_types=1);

namespace Sokil\Worker\Signal;

/**
 * @see /usr/include/bits/signum.h
 */
class SignalNumber
{
    public const SIGHUP = 1;
    
    /**
     * Interrupt (ANSI)
     * Ctrl+C in console
     */
    public const SIGINT = 2;
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
    public const SIGTERM = 15;
    public const SIGSTKFLT = 16;
    public const SIGCLD = 17;
    public const SIGCHLD = 17;
    public const SIGCONT = 18;
    
    /**
     * Stop (POSIX)
     * Unblockable
     */
    public const SIGSTOP = 19;
    
    /**
     * Keyboard stop (POSIX)
     * By default, this causes the process to suspend execution
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
