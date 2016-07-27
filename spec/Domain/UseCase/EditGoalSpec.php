<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\Model\Path;
use Domain\Model\Goal;
use Domain\UseCase\EditGoal\Responder;
use Domain\UseCase\EditGoal\Command;

class EditGoalSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_edit_a_goal_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Path $path,
        Goal $goal,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path);

        $path->getUserId()->willReturn($userId);
        $path->getGoal($goalId = 2)->willReturn($goal);

        $goal->setOrder(5)->shouldBeCalled();
        $goal->setAchieved(true)->shouldBeCalled();

        $pathsRepository->add($path)->shouldBeCalled();
        $pathsRepository->findByUserId($userId = 1)->willReturn($paths = [$path]);

        $responder->goalSuccesfullyEdited($paths)->shouldBeCalled();

        $command = new Command($userId, $goalId);
        $command->order = 5;
        $command->achieved = true;

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

        $this->execute(new Command($userId, $goalId = 2), $responder);
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

        $this->execute(new Command($userId, $goalId = 2), $responder);
    }
}
