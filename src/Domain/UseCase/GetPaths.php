<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\GetPaths\Command;
use Domain\UseCase\GetPaths\Responder;

class GetPaths
{
    private $pathsRepository;

    public function __construct(PathsRepository $pathsRepository)
    {
        $this->pathsRepository = $pathsRepository;
    }

    public function execute(Command $command, Responder $responder)
    {
        $paths = $this->pathsRepository->findByUserId($command->userId);

        $responder->pathsSuccessfullyRetrieved($paths);
    }
}
