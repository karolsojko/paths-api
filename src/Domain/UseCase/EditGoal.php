<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\EditGoal\Command;
use Domain\UseCase\EditGoal\Responder;

class EditGoal
{
    private $pathsRepository;

    public function __construct(PathsRepository $pathsRepository)
    {
        $this->pathsRepository = $pathsRepository;
    }

    public function execute(Command $command, Responder $responder)
    {
        $path = $this->pathsRepository->find($command->userId);
        if (empty($path)) {
            $responder->pathNotFound($command->userId);
            return;
        }

        $goal = $path->getGoal($command->goalId);
        if (empty($goal)) {
            $responder->goalNotFound($command->goalId);
            return;
        }

        if (isset($command->name)) {
            $goal->setName($command->name);
        }
        if (isset($command->description)) {
            $goal->setDescription($command->description);
        }
        if (isset($command->icon)) {
            $goal->setIcon($command->icon);
        }
        if (isset($command->level)) {
            $goal->setLevel($command->level);
        }
        if (isset($command->order)) {
            $goal->setOrder($command->order);
        }
        if (isset($command->dueDate)) {
            $goal->setDueDate($command->dueDate);
        }
        if (isset($command->achieved)) {
            $goal->setAchieved($command->achieved);
        }

        $this->pathsRepository->add($path);

        $responder->goalSuccesfullyEdited($goal);
    }
}
