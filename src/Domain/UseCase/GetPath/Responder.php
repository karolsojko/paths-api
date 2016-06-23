<?php

namespace Domain\UseCase\GetPath;
use Domain\Model\Path;

interface Responder
{
    public function pathSuccessfullyRetrieved(Path $path);

    public function pathNotFound($id);
}
