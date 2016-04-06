<?php

namespace Domain\UseCase\RemoveGoal;
use Domain\Model\Path;

interface Responder
{
    public function goalSuccessfullyRemovedFromPath(Path $path);

    public function pathNotFound($userId);
}
