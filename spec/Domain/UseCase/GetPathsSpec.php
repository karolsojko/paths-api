<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\UseCase\GetPaths\Responder;
use Domain\UseCase\GetPaths\Command;
use Domain\Model\Path;

class GetPathsSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_retrieve_a_path_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->findByUserId($userId = 1)->willReturn($paths = [new Path($userId)]);

        $responder->pathsSuccessfullyRetrieved($paths)->shouldBeCalled();

        $this->execute(new Command($userId), $responder);
    }
}
