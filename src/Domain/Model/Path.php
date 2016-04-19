<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;
use Domain\Model\Goal;

class Path
{
    private $userId;
    private $goals;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->goals = [];
    }

    public function getUserId()
    {
        return $this->userId;
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

    private function getNextOrderNumber()
    {
        return count($this->goals) + 1;
    }
}
