<?php

namespace Domain\UseCase\AddPath;
use Domain\Model\Path;

interface Responder
{
    public function pathSuccessfullyCreated(Path $path);

    public function pathAlreadyExists(Path $path);
}
