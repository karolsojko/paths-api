<?php

namespace AppBundle\Controller\Paths;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\AddPath\Responder;
use Domain\UseCase\AddPath\Command;
use Domain\Model\Path;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateController extends FOSRestController implements Responder
{
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Create a path",
     *   parameters={
     *     {"name"="userId", "dataType"="string", "required"=true, "description"="user id"}
     *   }
     * )
     */
    public function postPathsAction(Request $request)
    {
        $command = new Command($request->get('userId'));

        $useCase = $this->get('app.use_case.add_path');
        $useCase->execute($command, $this);

        return $this->handleView($this->view);
    }

    public function pathSuccessfullyCreated(Path $path)
    {
        $this->view = $this->view($path);
    }

    public function pathAlreadyExists(Path $path)
    {
        throw new HttpException(409, 'Path already exists');
    }
}
