<?php

namespace Domain\UseCase\RemoveGoal;

class Command
{
    public $id;
    public $goalId;

    public function __construct($id, $goalId)
    {
        $this->id = $id;
        $this->goalId = $goalId;
    }
}
