<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;
use Domain\Model\Goal;

class Comment
{
    private $id;
    private $userId;
    private $goalId;
    private $author;
    private $text;
    private $replies;
    private $timestamp;

    public function __construct($userId, $goalId, $author, $text)
    {
        $uuid = Uuid::uuid4();
        $this->id = $uuid->toString();
        $this->userId = $userId;
        $this->goalId = $goalId;
        $this->author = $author;
        $this->text = $text;
        $this->replies = [];
        $this->timestamp = time();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getGoalId()
    {
        return $this->goalId;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getReplies()
    {
        return $this->replies;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
