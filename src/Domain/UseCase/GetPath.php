<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\GetPath\Command;
use Domain\UseCase\GetPath\Responder;

class GetPath
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

        $responder->pathSuccessfullyRetrieved($path);
    }
}
