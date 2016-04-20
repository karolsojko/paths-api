<?php

namespace Domain\UseCase\AddComment;
use Domain\Model\Goal;

interface Responder
{
    public function pathNotFound($userId);

    public function goalNotFound($goalId);

    public function commentSuccesfullyAdded(Goal $goal);
}
