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
        $path = $this->pathsRepository->find($command->getUserId());
        if (empty($path)) {
            $responder->pathNotFound($command->getUserId());
            return;
        }

        $path->removeGoal($command->getGoalId());

        $this->pathsRepository->add($path);

        $responder->goalSuccessfullyRemovedFromPath($path);
    }
}
