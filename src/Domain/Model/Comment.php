<?php

namespace Domain\Model;

use Ramsey\Uuid\Uuid;

class Comment
{
    private $id;
    private $author;
    private $authorDisplayName;
    private $text;
    private $replies;
    private $timestamp;

    public function __construct($author, $text)
    {
        $uuid = Uuid::uuid4();
        $this->id = $uuid->toString();
        $this->author = $author;
        $this->text = $text;
        $this->replies = [];
        $this->timestamp = time();
    }

    public function getId()
    {
        return $this->id;
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

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setAuthorDisplayName($authorDisplayName)
    {
        $this->authorDisplayName = $authorDisplayName;
    }

    public function getAuthorDisplayName()
    {
        return $this->authorDisplayName;
    }

    public function addReply(Comment $comment)
    {
        $this->replies[] = $comment;
    }
}
