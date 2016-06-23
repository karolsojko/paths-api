<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\RemoveGoal\Command;
use Domain\UseCase\RemoveGoal\Responder;
use Domain\Model\Goal;

class RemoveGoal
{
    private $pathsRepository;

    public function __construct(PathsRepository $pathsRepository)
    {
        $this->pathsRepository = $pathsRepository;
    }

    public function execute(Command $command, Responder $responder)
    {
        $path = $this->pathsRepository->find($command->id);
        if (empty($path)) {
            $responder->pathNotFound($command->id);
            return;
        }

        $path->removeGoal($command->goalId);

        $this->pathsRepository->add($path);

        $responder->goalSuccessfullyRemovedFromPath($path);
    }
}
