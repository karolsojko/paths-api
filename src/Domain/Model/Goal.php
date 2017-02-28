<?php

namespace Domain\Model;

class Goal extends Achievement
{
    private $comments;
    private $unread;
    private $lastNotificationSent;
    private $steps;

    public function __construct($name, $description)
    {
        $this->comments = [];
        $this->steps = [];
        $this->unread = 0;
        parent::__construct($name, $description);
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

    /**
     * @param Step
     */
    public function addStep(Step $step)
    {
        $this->steps[] = $step;
    }

    /**
     * @return Step[]
     */
    public function getSteps()
    {
        return $this->steps;
    }

    public function getLastNotificationSent()
    {
        return $this->lastNotificationSent;
    }

    public function setLastNotificationSent($lastNotificationSent)
    {
        $this->lastNotificationSent = $lastNotificationSent;
    }
}
