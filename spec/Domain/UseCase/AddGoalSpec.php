<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\Model\Path;
use Domain\Model\Goal;
use Domain\UseCase\AddGoal\Responder;
use Domain\UseCase\AddGoal\Command;

class AddGoalSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_add_a_goal_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Path $path,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path);

        $path->addGoal(Argument::type(Goal::class))->shouldBeCalled();

        $pathsRepository->add($path)->shouldBeCalled();

        $responder
            ->goalSuccessfullyAddedToPath($path)
            ->shouldBeCalled();

        $this->execute(
            new Command(
                $userId,
                $name = 'PHP Master',
                $description = 'Complete online PHP Course'
            ),
            $responder
        );
    }

    function it_should_notify_the_responder_if_path_was_not_found(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn(null);

        $responder
            ->pathNotFound($userId)
            ->shouldBeCalled();

        $this->execute(
            new Command(
                $userId,
                $name = 'PHP Master',
                $description = 'Complete online PHP Course'
            ),
            $responder
        );
    }
}
