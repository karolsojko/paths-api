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
        $path = new Path();
        if (!empty($command->userId)) {
            $path->setUserId($command->userId);
        }
        if (!empty($command->type)) {
            $path->setType($command->type);
        }

        $this->pathsRepository->add($path);

        if (!empty($command->userId)) {
            $paths = $this->pathsRepository->findByUserId($command->userId);
        } else {
            $paths = [$path];
        }

        $responder->pathSuccessfullyCreated($paths);
    }
}
