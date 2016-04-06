<?php

namespace Domain\UseCase\AddGoal;

use Domain\Model\Path;

interface Responder
{
    public function goalSuccessfullyAddedToPath(Path $path);

    public function pathNotFound($userId);
}
