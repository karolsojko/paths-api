<?php

namespace Domain\UseCase\EditGoal;

use Domain\Model\Path;

interface Responder
{
    public function pathNotFound($id);

    public function goalSuccesfullyEdited($paths);

    public function goalNotFound($goalId);
}
