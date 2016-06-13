<?php

namespace Domain\UseCase\AddPath;

class Command
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
