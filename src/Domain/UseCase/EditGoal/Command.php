<?php

namespace Domain\UseCase\EditGoal;

class Command
{
    public $userId;
    public $goalId;
    public $name;
    public $description;
    public $icon;
    public $level;
    public $order;
    public $dueDate;
    public $achieved;
    public $unread;

    public function __construct($userId, $goalId)
    {
        $this->userId = $userId;
        $this->goalId = $goalId;
    }
}
