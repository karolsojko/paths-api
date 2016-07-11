<?php

namespace AppBundle\Controller\Paths;

use Domain\Model\Path;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\EditPath\Responder;
use Domain\UseCase\EditPath\Command;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UpdateController extends FOSRestController implements Responder
{
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Update a path",
     *   parameters={
     *     {"name"="name", "dataType"="string", "required"=false, "description"="path name"}
     *   }
     * )
     */
    public function putPathsAction($id, Request $request)
    {
        $name = $request->get('name');

        $command = new Command($id);
        $command->name = $name;

        $useCase = $this->get('app.use_case.edit_path');
        $useCase->execute($command, $this);

        return $this->handleView($this->view);
    }

    public function pathSuccessfullyUpdated(Path $path)
    {
        $this->view = $this->view($path);

        $cacheManager = $this->get('fos_http_cache.cache_manager');
        $cacheManager
            ->invalidateRoute('get_paths', ['userId' => $path->getUserId()])
            ->flush();
    }

    public function pathNotFound($id)
    {
        throw $this->createNotFoundException('Path not found');
    }
}
