<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;

class Goal
{
    private $id;
    private $name;
    private $description;
    private $icon;
    private $level;

    public function __construct($name, $description)
    {
        $uuid = Uuid::uuid4();
        $this->id = $uuid->toString();
        $this->name = $name;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getIcon()
    {
        return $this->icon;
    }
}
