<?php

namespace Domain\UseCase\EditGoal;

class Command
{
    public $id;
    public $goalId;
    public $name;
    public $description;
    public $icon;
    public $level;
    public $order;
    public $dueDate;
    public $achieved;
    public $unread;
    public $lastNotificationSent;
    public $unsetDueDate = false;

    public function __construct($id, $goalId)
    {
        $this->id = $id;
        $this->goalId = $goalId;
    }
}
