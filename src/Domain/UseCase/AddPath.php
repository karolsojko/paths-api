<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\AddPath\Command;
use Domain\UseCase\AddPath\Responder;
use Domain\Model\Path;

class AddPath
{
    private $pathsRepository;

    public function __construct(PathsRepository $pathsRepository)
    {
        $this->pathsRepository = $pathsRepository;
    }

    public function execute(Command $command, Responder $responder)
    {
        $path = $this->pathsRepository->find($command->getUserId());
        if (!empty($path)) {
            $responder->pathAlreadyExists($path);
            return;
        }

        $path = new Path($command->getUserId());

        $this->pathsRepository->add($path);

        $responder->pathSuccessfullyCreated($path);
    }
}
