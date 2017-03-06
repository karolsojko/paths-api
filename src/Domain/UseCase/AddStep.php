<?php

namespace Domain\UseCase;

use Domain\UseCase\AddStep;
use Domain\Repository\PathsRepository;
use Domain\Model\Step;

class AddStep
{
    private $pathsRepository;

    /**
     * @param PathsRepository $pathsRepository
     */
    public function __construct(PathsRepository $pathsRepository)
    {
        $this->pathsRepository = $pathsRepository;
    }

    /**
     * @param AddStep\Command   $command
     * @param AddStep\Responder $responder
     */
    public function execute(
        AddStep\Command $command,
        AddStep\Responder $responder
    ) {
        $path = $this->pathsRepository->find($command->id);
        if (empty($path)) {
            $responder->pathNotFound($command->id);
            return;
        }

        $goal = $path->getGoal($command->goalId);
        if (empty($goal)) {
            $responder->goalNotFound($command->goalId);
            return;
        }

        $step = new Step($command->name, $command->description);
        $step->setOrder($command->order);
        $step->setIcon($command->icon);
        $step->setDueDate($command->dueDate);
        $step->setLevel($command->level);

        $goal->addStep($step);
        $this->pathsRepository->add($path);

        $responder->stepSuccessfullyAddedToGoal($goal);
    }
}
