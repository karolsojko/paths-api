<?php

namespace AppBundle\Controller\Paths\Goals;

use FOS\RestBundle\Controller\FOSRestController;
use Domain\UseCase\RemoveGoal\Responder;
use Domain\UseCase\RemoveGoal\Command;
use Domain\Model\Path;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DeleteController extends FOSRestController implements Responder
{
    private $id;
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Delete a goal from path",
     *   parameters={
     *     {"name"="id", "dataType"="string", "description"="path id"},
     *     {"name"="goalId", "dataType"="string", "required"=true, "description"="goal id"}
     *   }
     * )
     */
    public function deletePathsGoalsAction($id, $goalId)
    {
        $this->id = $id;
        $useCase = $this->get('app.use_case.remove_path_goal');
        $useCase->execute(new Command($id, $goalId), $this);

        return $this->handleView($this->view);
    }

    public function goalSuccessfullyRemovedFromPath(Path $path)
    {
        $this->view = $this->view(null, 204);

        $cacheManager = $this->get('fos_http_cache.cache_manager');
        $cacheManager
            ->invalidateRoute('get_path', ['id' => $this->id])
            ->invalidateRoute('get_paths', ['userId' => $path->getUserId()])
            ->flush();
    }

    public function pathNotFound($id)
    {
        throw $this->createNotFoundException('Path does not exist');
    }
}
