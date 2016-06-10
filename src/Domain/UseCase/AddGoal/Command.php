<?php

namespace Domain\UseCase\AddGoal;

class Command
{
    public $id;
    public $name;
    public $description;
    public $icon;
    public $level;
    public $order;
    public $dueDate;

    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
}
