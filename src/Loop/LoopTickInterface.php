<?php
declare(strict_types=1);

namespace Sokil\Worker\Loop;

interface LoopTickInterface
{
    public function execute();
}
