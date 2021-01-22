<?php

namespace Hr\Infrastructure\Contracts;

interface ShouldTerminateInterface
{
    public function terminate(): void;
}