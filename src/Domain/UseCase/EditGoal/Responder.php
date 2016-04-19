<?php

namespace Domain\UseCase\EditGoal;
use Domain\Model\Goal;

interface Responder
{
    public function pathNotFound($userId);

    public function goalSuccesfullyEdited(Goal $goal);

    public function goalNotFound($goalId);
}
