<?php

namespace AppBundle\Controller\Paths;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\GetPath\Responder;
use Domain\UseCase\GetPath\Command;
use Domain\Model\Path;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ReadController extends FOSRestController implements Responder
{
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Get path details"
     * )
     */
    public function getPathsAction($userId)
    {
        $useCase = $this->get('app.use_case.get_path');
        $useCase->execute(new Command($userId), $this);

        return $this->handleView($this->view);
    }

    public function pathSuccessfullyRetrieved(Path $path)
    {
        $this->view = $this->view($path);
    }

    public function pathNotFound($userId)
    {
        throw $this->createNotFoundException('Path does not exist');
    }
}
