<?php

namespace Leaf\Pcntl\ProcessPool;

use Leaf\Pcntl\Process;
use Leaf\Pcntl\ProcessPool\Base\ProcessPoolAbstract;

/**
 * Class ProcessPoolFixed
 * process pool manager. It's designed as PHP-FPM. you can set  a fixed number of  child processes
 *
 * @package Leaf\Pcntl\ProcessPool
 */
class ProcessPoolFixed extends ProcessPoolAbstract
{

    /**
     * the fixed number of child process
     * a fixed number of child processes
     *
     * @var int
     */
    protected $fixedProcessNum = 2;

    /**
     * the current number of processes
     *
     * @var int
     */
    protected $currentProcessNum = 0;

    /**
     * Put a process in the pool, then you can start them by self::execute
     *
     * @param Process $process
     *
     * @return $this
     */
    public function addProcess(Process $process)
    {
        //check if the process has the correct pid
        $pid = $process->getPid();
        if ( !empty( $pid )) {
            $this->processPool[$pid] = $process;
        }
        else {
            throw new \InvalidArgumentException('the process is invaliad!');
        }

        return $this;
    }

    /**
     * start the processes in the pool
     */
    public function execute()
    {
        if ( !empty( $this->processPool )) {
            foreach ($this->processPool as $process) {
                $process->start();
            }
        }
    }

    /**
     *
     */
    public function wait()
    {

    }

}