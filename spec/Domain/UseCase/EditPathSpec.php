<?php

namespace spec\Domain\UseCase;

use Domain\Model\Path;
use Domain\Repository\PathsRepository;
use Domain\UseCase\EditPath\Command;
use Domain\UseCase\EditPath\Responder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditPathSpec extends ObjectBehavior
{
    function let(PathsRepository $pathsRepository)
    {
        $this->beConstructedWith($pathsRepository);
    }

    function it_should_add_a_path_and_notify_the_responder(
        PathsRepository $pathsRepository,
        Path $path,
        Responder $responder
    ) {
        $pathsRepository->find($id = 1)->willReturn($path);

        $path->setName($name = 'test')->shouldBeCalled();

        $pathsRepository->add($path)->shouldBeCalled();

        $responder->pathSuccessfullyUpdated($path)->shouldBeCalled();

        $command = new Command($id);
        $command->name = 'test';

        $this->execute($command, $responder);
    }

    function it_should_notify_the_responder_if_path_not_found(
        PathsRepository $pathsRepository,
        Responder $responder
    ) {
        $pathsRepository->find($id = 1)->willReturn(null);

        $responder->pathNotFound($id)->shouldBeCalled();

        $command = new Command($id);
        $command->name = 'test';

        $this->execute($command, $responder);
    }
}
