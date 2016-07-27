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
            $goal->setLevel(intval($command->level));
        }
        if (isset($command->order)) {
            $goal->setOrder(intval($command->order));
        }
        if (isset($command->dueDate)) {
            $goal->setDueDate($command->dueDate);
        }
        if ($command->unsetDueDate) {
            $goal->unsetDueDate();
        }
        if (isset($command->achieved)) {
            $goal->setAchieved($command->achieved);
        }
        if (isset($command->unread)) {
            $goal->setUnread($command->unread);
        }
        if (isset($command->lastNotificationSent)) {
            $goal->setLastNotificationSent($command->lastNotificationSent);
        }

        if (!empty($command->newPathId)) {
            $newPath = $this->pathsRepository->find($command->newPathId);
            if (empty($newPath)) {
                $responder->pathNotFound($command->newPathId);
                return;
            }

            $newPath->addGoal($goal);
            $path->removeGoal($goal->getId());

            $this->pathsRepository->add($newPath);
        }

        $this->pathsRepository->add($path);

        $paths = $this->pathsRepository->findByUserId($path->getUserId());

        $responder->goalSuccesfullyEdited($paths);
    }
}
