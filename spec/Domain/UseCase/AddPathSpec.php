<?php

namespace spec\Domain\UseCase;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Repository\PathsRepository;
use Domain\UseCase\AddPath\Responder;
use Domain\UseCase\AddPath\Command;
use Domain\Model\Path;

class AddPathSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_retrieve_a_path_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->find($userId = 1)->willReturn(null);

        $pathsRepository->add(Argument::type(Path::class))->shouldBeCalled();

        $responder->pathSuccessfullyCreated(Argument::type(Path::class))->shouldBeCalled();

        $this->execute(new Command($userId), $responder);
    }
}
