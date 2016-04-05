<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\UseCase\GetPath\Responder;
use Domain\UseCase\GetPath\Command;
use Domain\Model\Path;

class GetPathSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_retrieve_a_path_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn($path = new Path($userId));

        $responder->pathSuccessfullyRetrieved($path)->shouldBeCalled();

        $this->execute(new Command($userId), $responder);
    }

    function it_should_notify_the_responder_if_path_was_not_found(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn(null);

        $responder->pathNotFound($userId)->shouldBeCalled();

        $this->execute(new Command($userId), $responder);
    }
}
