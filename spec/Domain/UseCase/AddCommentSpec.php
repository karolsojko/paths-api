<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\Model\Comment;
use Domain\Model\Path;
use Domain\Model\Goal;
use Domain\UseCase\AddComment\Responder;
use Domain\UseCase\AddComment\Command;

class AddCommentSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_add_comment_to_a_goal_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Path $path,
        Goal $goal,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path);

        $path->getGoal($goalId = 2)->willReturn($goal);
        $path->getUserId()->willReturn($userId);

        $goal->addComment(Argument::type(Comment::class))->shouldBeCalled();

        $pathsRepository->add($path)->shouldBeCalled();

        $responder->commentSuccesfullyAdded($goal, $userId)->shouldBeCalled();

        $command =
            new Command($userId, $goalId, $author = 'John Doe', $text = 'test');

        $this->execute($command, $responder);
    }

    function it_should_notify_the_responder_if_path_was_not_found(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn(null);

        $responder
            ->pathNotFound($userId)
            ->shouldBeCalled();

        $command =
            new Command($userId, $goalId = 2, $author = 'John Doe', $text = 'test');

        $this->execute($command, $responder);
    }

    function it_should_notify_the_responder_if_goal_was_not_found(
        PathsRepository $pathsRepository,
        Path $path,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path);

        $path->getGoal($goalId = 2)->willReturn(null);

        $responder
            ->goalNotFound($goalId)
            ->shouldBeCalled();

        $command =
            new Command($userId, $goalId, $author = 'John Doe', $text = 'test');

        $this->execute($command, $responder);
    }
}
