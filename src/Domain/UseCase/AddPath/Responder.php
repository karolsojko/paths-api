<?php

namespace Domain\UseCase\AddPath;

interface Responder
{
    public function pathSuccessfullyCreated($paths);
}
