<?php

namespace Domain\UseCase;

use Domain\Repository\PathsRepository;
use Domain\UseCase\AddComment\Command;
use Domain\UseCase\AddComment\Responder;
use Domain\Model\Comment;

class AddComment
{
    private $pathsRepository;

    public function __construct(PathsRepository $pathsRepository)
    {
        $this->pathsRepository = $pathsRepository;
    }

    public function execute(Command $command, Responder $responder)
    {
        $path = $this->pathsRepository->find($command->id);
        if (empty($path)) {
            $responder->pathNotFound($command->id);
            return;
        }

        $goal = $path->getGoal($command->goalId);
        if (empty($goal)) {
            $responder->goalNotFound($command->goalId);
            return;
        }

        $comment = new Comment($command->author, $command->text);
        $comment->setAuthorDisplayName($command->authorDisplayName);

        if (isset($command->replyTo)) {
            $goal->addCommentReply($command->replyTo, $comment);
        } else {
            $goal->addComment($comment);
        }

        $this->pathsRepository->add($path);

        $responder->commentSuccesfullyAdded($goal);
    }
}
