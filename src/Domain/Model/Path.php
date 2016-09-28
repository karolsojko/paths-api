<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;

class Path
{
    const TYPE_USER_PATH = 'user';
    const TYPE_CURATED_PATH = 'curated';

    private $id;
    private $userId;
    private $type;
    private $name;
    private $goals;

    public function __construct()
    {
        $uuid = Uuid::uuid4();
        $this->id = $uuid->toString();
        $this->goals = [];
        $this->type = self::TYPE_USER_PATH;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getGoals()
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal)
    {
        if ($goal->getOrder() === null) {
            $goal->setOrder($this->getNextOrderNumber());
        }

        $this->goals[] = $goal;
    }

    public function removeGoal($goalId)
    {
        $index = null;
        foreach ($this->goals as $key => $goal) {
            if ($goal->getId() == $goalId) {
                $index = $key;
                break;
            }
        }

        if ($index !== null) {
            unset($this->goals[$index]);
        }
    }

    public function getGoal($goalId)
    {
      foreach ($this->goals as $goal) {
          if ($goal->getId() == $goalId) {
              return $goal;
          }
      }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    private function getNextOrderNumber()
    {
        return count($this->goals) + 1;
    }
}
