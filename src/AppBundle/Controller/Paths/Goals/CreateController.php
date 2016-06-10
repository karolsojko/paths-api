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
    private $id;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Create a goal",
     *   parameters={
     *     {"name"="id", "dataType"="string", "required"=true, "description"="path id"},
     *     {"name"="name", "dataType"="string", "required"=true, "description"="goal name"},
     *     {"name"="description", "dataType"="string", "required"=true, "description"="goal description"},
     *     {"name"="icon", "dataType"="string", "required"=false, "description"="goal icon url"},
     *     {"name"="order", "dataType"="integer", "required"=false, "description"="order number"},
     *     {"name"="dueDate", "dataType"="DateTime", "required"=false, "description"="due date"},
     *     {"name"="level", "dataType"="integer", "required"=false, "description"="goal level"}
     *   }
     * )
     */
    public function postPathsGoalsAction($id, Request $request)
    {
        $this->id = $id;
        $useCase = $this->get('app.use_case.add_path_goal');

        $name = $request->get('name');
        $description = $request->get('description');
        $icon = $request->get('icon');
        $level = $request->get('level');
        $order = $request->get('order');
        $dueDate = $request->get('dueDate');

        if (empty($name) || empty($description)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $command = new Command($id, $name, $description);

        if (!empty($icon)) {
            $command->icon = $icon;
        }
        if (!empty($level)) {
            $command->level = $level;
        }
        if (isset($order)) {
            $command->order = $order;
        }
        if (!empty($dueDate)) {
            $command->dueDate = $dueDate;
        }

        $useCase->execute($command, $this);

        return $this->handleView($this->view);
    }

    public function goalSuccessfullyAddedToPath(Path $path)
    {
        $this->view = $this->view($path);

        $cacheManager = $this->get('fos_http_cache.cache_manager');
        $cacheManager
            ->invalidateRoute('get_path', array('id' => $this->id))
            ->invalidateRoute('get_paths')
            ->flush();
    }

    public function pathNotFound($id)
    {
        throw $this->createNotFoundException('Path does not exist');
    }
}
