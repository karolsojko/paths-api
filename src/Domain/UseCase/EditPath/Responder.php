<?php

namespace Domain\UseCase\EditPath;

use Domain\Model\Path;

interface Responder
{
    public function pathSuccessfullyUpdated(Path $path);

    public function pathNotFound($id);
}
