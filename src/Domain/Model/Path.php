<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;

class Path
{
    private $userId;
    private $goals;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->goals = [];
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getGoals()
    {
        return $this->goals;
    }
}
