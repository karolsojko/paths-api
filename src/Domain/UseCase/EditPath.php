<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\EditPath\Command;
use Domain\UseCase\EditPath\Responder;

class EditPath
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

        $path->setName($command->name);
        $this->pathsRepository->add($path);

        $responder->pathSuccessfullyUpdated($path);
    }
}
