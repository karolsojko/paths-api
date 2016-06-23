<?php

namespace Domain\UseCase\GetPaths;

class Command
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
