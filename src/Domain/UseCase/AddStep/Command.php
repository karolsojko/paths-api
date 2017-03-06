<?php

namespace Domain\UseCase\AddStep;

use Domain\Model\Goal;

class Command
{

    public $id;
    public $goalId;
    public $name;
    public $description;
    public $order;
    public $level;
    public $dueDate;
    public $icon;

    /**
     * @param string $id
     * @param string $goalId
     * @param string $name
     * @param string $description
     */
    public function __construct(
        string $id,
        string $goalId,
        string $name,
        string $description
    ) {
        $this->id = $id;
        $this->goalId = $goalId;
        $this->name = $name;
        $this->description = $description;
    }
}
