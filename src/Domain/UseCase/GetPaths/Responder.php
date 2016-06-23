<?php

namespace Domain\UseCase\GetPaths;

interface Responder
{
    public function pathsSuccessfullyRetrieved($paths);
}
