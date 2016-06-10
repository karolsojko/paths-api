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
        $path = $this->pathsRepository->find($command->id);
        if (empty($path)) {
            $responder->pathNotFound($command->id);
            return;
        }

        $goal = new Goal($command->name, $command->description);
        $goal->setIcon($command->icon);
        $goal->setLevel($command->level);
        $goal->setOrder($command->order);
        $goal->setDueDate($command->dueDate);

        $path->addGoal($goal);

        $this->pathsRepository->add($path);

        $responder->goalSuccessfullyAddedToPath($path);
    }
}
