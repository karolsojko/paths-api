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
    private $order;
    private $dueDate;
    private $achieved;

    public function __construct($name, $description)
    {
        $uuid = Uuid::uuid4();
        $this->id = $uuid->toString();
        $this->name = $name;
        $this->description = $description;
        $this->achieved = false;
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

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function isAchieved()
    {
        return $this->achieved;
    }

    public function setAchieved($achieved)
    {
        $this->achieved = $achieved;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
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
