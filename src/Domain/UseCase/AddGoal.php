<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\AddGoal\Command;
use Domain\UseCase\AddGoal\Responder;
use Domain\Model\Goal;

class AddGoal
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

        $goal = new Goal($command->getName(), $command->getDescription());
        $goal->setIcon($command->getIcon());
        $goal->setLevel($command->getLevel());

        $path->addGoal($goal);

        $this->pathsRepository->add($path);

        $responder->goalSuccessfullyAddedToPath($path);
    }
}
