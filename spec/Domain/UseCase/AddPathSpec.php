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

    function it_should_add_a_path_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->add(Argument::type(Path::class))->shouldBeCalled();

        $pathsRepository->findByUserId($userId = 1)->willReturn($paths = []);

        $responder->pathSuccessfullyCreated(Argument::cetera())->shouldBeCalled();

        $this->execute(new Command($userId), $responder);
    }
}
