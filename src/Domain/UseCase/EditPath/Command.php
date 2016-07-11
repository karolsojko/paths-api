<?php

namespace Domain\UseCase\EditPath;

class Command
{
    public $id;
    public $name;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
