<?php

namespace AppBundle\Controller\Paths\Goals;

use FOS\RestBundle\Controller\FOSRestController;
use Domain\UseCase\RemoveGoal\Responder;
use Domain\UseCase\RemoveGoal\Command;
use Domain\Model\Path;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DeleteController extends FOSRestController implements Responder
{
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Delete a goal from path",
     *   parameters={
     *     {"name"="userId", "dataType"="string", "description"="path id"},
     *     {"name"="id", "dataType"="string", "required"=true, "description"="goal id"}
     *   }
     * )
     */
    public function deletePathsGoalsAction($userId, $id)
    {
        $useCase = $this->get('app.use_case.remove_path_goal');
        $useCase->execute(new Command($userId, $id), $this);

        return $this->handleView($this->view);
    }

    public function goalSuccessfullyRemovedFromPath(Path $path)
    {
        $this->view = $this->view(null, 204);
    }

    public function pathNotFound($userId)
    {
        throw $this->createNotFoundException('Path does not exist');
    }
}
