<?php

namespace Domain\UseCase\AddComment;

class Command
{
    public $id;
    public $goalId;
    public $author;
    public $authorDisplayName;
    public $text;
    public $replyTo;

    public function __construct($id, $goalId, $author, $text)
    {
        $this->id = $id;
        $this->goalId = $goalId;
        $this->author = $author;
        $this->text = $text;
    }
}
