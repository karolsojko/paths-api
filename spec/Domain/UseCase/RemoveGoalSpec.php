<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\Model\Path;
use Domain\Model\Goal;
use Domain\UseCase\RemoveGoal\Responder;
use Domain\UseCase\RemoveGoal\Command;

class RemoveGoalSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_remove_a_goal_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Path $path,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path);

        $path->removeGoal($goalId = 2)->shouldBeCalled();

        $pathsRepository->add($path)->shouldBeCalled();

        $responder
            ->goalSuccessfullyRemovedFromPath($path)
            ->shouldBeCalled();

        $this->execute(new Command($userId, $goalId), $responder);
    }
}
