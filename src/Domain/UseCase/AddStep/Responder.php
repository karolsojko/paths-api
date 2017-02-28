<?php

namespace Domain\UseCase\AddStep;

use Domain\Model\Goal;

interface Responder
{

    /**
     * @param  Goal $goal
     */
    public function stepSuccessfullyAddedToGoal(Goal $goal);

    /**
     * @param  string $id
     */
    public function pathNotFound(string $id);

    /**
     * @param  string $id
     */
    public function goalNotFound(string $goalId);
}
