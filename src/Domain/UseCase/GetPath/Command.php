<?php

namespace Domain\UseCase\GetPath;

class Command
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
