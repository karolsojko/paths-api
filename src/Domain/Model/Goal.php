<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;
use Domain\Model\Comment;

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
    private $comments;
    private $unread;

    public function __construct($name, $description)
    {
        $uuid = Uuid::uuid4();
        $this->id = $uuid->toString();
        $this->name = $name;
        $this->description = $description;
        $this->achieved = false;
        $this->comments = [];
        $this->unread = 0;
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

    public function getUnread()
    {
        return $this->unread;
    }

    public function setUnread($unread)
    {
        $this->unread = $unread;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $this->unread++;
    }

    public function addCommentReply($replyTo, $comment)
    {
        foreach ($this->comments as $existingComment) {
            if ($existingComment->getId() === $replyTo) {
                $existingComment->addReply($comment);
            }
        }
    }
}
