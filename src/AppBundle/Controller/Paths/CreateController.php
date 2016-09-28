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
    private $userId;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Create a path",
     *   parameters={
     *     {"name"="userId", "dataType"="string", "required"=false, "description"="user id"},
     *     {"name"="type", "dataType"="string", "required"=false, "description"="type: user or curated"}
     *   }
     * )
     */
    public function postPathsAction(Request $request)
    {
        $userId = $request->get('userId');
        $type = $request->get('type');

        $this->userId = $userId;

        $command = new Command();
        if (!empty($userId)) {
            $command->userId = $userId;
        }
        if (!empty($type)) {
            $command->type = $type;
        }

        $useCase = $this->get('app.use_case.add_path');
        $useCase->execute($command, $this);

        return $this->handleView($this->view);
    }

    public function pathSuccessfullyCreated($paths)
    {
        $this->view = $this->view($paths);

        $cacheManager = $this->get('fos_http_cache.cache_manager');
        $cacheManager
            ->invalidateRoute('get_paths', ['userId' => $this->userId])
            ->flush();
    }
}
