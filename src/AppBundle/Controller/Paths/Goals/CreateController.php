<?php

namespace AppBundle\Controller\Paths\Goals;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\AddGoal\Responder;
use Domain\UseCase\AddGoal\Command;
use Domain\Model\Path;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateController extends FOSRestController implements Responder
{
    private $view;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Create a goal",
     *   parameters={
     *     {"name"="userId", "dataType"="string", "required"=true, "description"="user id"},
     *     {"name"="name", "dataType"="string", "required"=true, "description"="goal name"},
     *     {"name"="description", "dataType"="string", "required"=true, "description"="goal description"},
     *     {"name"="icon", "dataType"="string", "required"=false, "description"="goal icon url"},
     *     {"name"="level", "dataType"="integer", "required"=false, "description"="goal level"}
     *   }
     * )
     */
    public function postPathsGoalsAction($userId, Request $request)
    {
        $useCase = $this->get('app.use_case.add_path_goal');

        $name = $request->get('name');
        $description = $request->get('description');
        $icon = $request->get('icon');
        $level = $request->get('level');

        if (empty($name) || empty($description)) {
          throw new HttpException(400, 'Missing required parameters');
        }

        $command = new Command($userId, $name, $description);

        if (!empty($icon)) {
          $command->setIcon($icon);
        }
        if (!empty($level)) {
          $command->setLevel($level);
        }

        $useCase->execute($command, $this);

        return $this->handleView($this->view);
    }

    public function goalSuccessfullyAddedToPath(Path $path)
    {
        $this->view = $this->view($path);
    }

    public function pathNotFound($userId)
    {
        throw $this->createNotFoundException('Path does not exist');
    }
}
