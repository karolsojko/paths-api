<?php

namespace AppBundle\Controller\Paths;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\GetPath;
use Domain\UseCase\GetPaths;
use Domain\Model\Path;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReadController extends FOSRestController implements
    GetPath\Responder,
    GetPaths\Responder
{
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Get all paths for a given user",
     *   parameters={
     *     {"name"="userId", "dataType"="string", "required"=true, "description"="user id"}
     *   }
     * )
     */
    public function getPathsAction(Request $request)
    {
        $userId = $request->get('userId');
        if (empty($userId)) {
            throw new HttpException(400, 'Missing required parameters: userId');
        }

        $useCase = $this->get('app.use_case.get_paths');
        $useCase->execute(new GetPaths\Command($userId), $this);

        return $this->handleView($this->view);
    }

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Get path details"
     * )
     */
    public function getPathAction($id)
    {
        $useCase = $this->get('app.use_case.get_path');
        $useCase->execute(new GetPath\Command($id), $this);

        return $this->handleView($this->view);
    }

    public function pathSuccessfullyRetrieved(Path $path)
    {
        $this->view = $this->view($path);
    }

    public function pathNotFound($id)
    {
        throw $this->createNotFoundException('Path does not exist');
    }

    public function pathsSuccessfullyRetrieved($paths)
    {
        $this->view = $this->view($paths);
    }
}
