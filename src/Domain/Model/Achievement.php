<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;

abstract class Achievement
{

	protected $id;
	protected $name;
	protected $description;
	protected $achieved;
	protected $level;
	protected $order;
	protected $dueDate;
	protected $icon;

    /**
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
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

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function isAchieved()
    {
        return $this->achieved;
    }

    public function setAchieved($achieved)
    {
        $this->achieved = $achieved;
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

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    public function unsetDueDate()
    {
        $this->dueDate = null;
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
