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
        $this->pathsRepository->add(new Path($command->userId));

        $paths = $this->pathsRepository->findByUserId($command->userId);

        $responder->pathSuccessfullyCreated($paths);
    }
}
