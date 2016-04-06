<?php

namespace Domain\UseCase\RemoveGoal;

class Command
{
    private $userId;
    private $goalId;

    public function __construct($userId, $goalId)
    {
        $this->userId = $userId;
        $this->goalId = $goalId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getGoalId()
    {
        return $this->goalId;
    }
}
