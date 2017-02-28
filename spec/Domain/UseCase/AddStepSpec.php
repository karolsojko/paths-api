<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Domain\UseCase\AddStep;
use Domain\UseCase\EditGoal;
use Domain\Model\Goal;
use Domain\Model\Path;
use Domain\Model\Step;
use Domain\Repository\PathsRepository;

class AddStepSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\UseCase\AddStep');
    }

    function it_should_add_a_step_and_notify_the_responder(
        Goal $goal,
        Path $path,
        AddStep\Responder $responder,
        PathsRepository $pathsRepository
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path);

        $path->getGoal($goalId = 2)->willReturn($goal);
        $path->getUserId()->willReturn($userId);

        $goal->addStep(Argument::type(Step::class))->shouldBeCalled();
        $pathsRepository->add($path)->shouldBeCalled();
        $responder->stepSuccessfullyAddedToGoal($goal)->shouldBeCalled();

        $this->execute(
            new AddStep\Command(
                $userId,
                $goalId,
                $name = 'PHP',
                $description = 'I learned PHP functions and variables.'
            ),
            $responder
        );
    }
}
