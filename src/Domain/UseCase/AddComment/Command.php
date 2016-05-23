<?php

namespace Domain\UseCase\AddComment;

class Command
{
    public $userId;
    public $goalId;
    public $author;
    public $authorDisplayName;
    public $text;
    public $replyTo;

    public function __construct($userId, $goalId, $author, $text)
    {
        $this->userId = $userId;
        $this->goalId = $goalId;
        $this->author = $author;
        $this->text = $text;
    }
}
