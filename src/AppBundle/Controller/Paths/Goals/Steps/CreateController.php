<?php

namespace AppBundle\Controller\Paths\Goals\Steps;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Domain\UseCase\AddStep;
use Domain\Model\Goal;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateController extends FOSRestController implements AddStep\Responder
{

    private $view;
    private $id;

    /**
     * @ApiDoc(
     *   resource=true,
     *   description="Create a step",
     *   parameters={
     *     {"name"="id", "dataType"="string", "required"=true, "description"="path id"},
     *     {"name"="goalId", "dataType"="string", "required"=true, "description"="goal id"},
     *     {"name"="name", "dataType"="string", "required"=true, "description"="step name"},
     *     {"name"="description", "dataType"="string", "required"=false, "step description"},
     *     {"name"="icon", "dataType"="string", "required"=false, "description"="step icon url"},
     *     {"name"="order", "dataType"="integer", "required"=false, "description"="order number"},
     *     {"name"="dueDate", "dataType"="DateTime", "required"=false, "description"="step due date"},
     *     {"name"="level", "dataType"="integer", "required"=false, "description"="step level"}
     *   }
     * )
     */
    public function postPathsGoalsStepAction(
        string $id,
        string $goalId,
        Request $request
    ) {
        $this->id = $id;
        $useCase = $this->get('app.use_case.add_path_goal_step');

        $stepName = $request->get('name');
        $stepDescription = $request->get('description');

        if (empty($stepName) || empty($stepDescription)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $icon = $request->get('icon');
        $level = $request->get('level');
        $order = $request->get('order');
        $dueDate = $request->get('dueDate');

        $command = new AddStep\Command(
            $id,
            $goalId,
            $stepName,
            $stepDescription
        );

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

    /**
     * @param  Goal $goal
     */
    public function stepSuccessfullyAddedToGoal(Goal $goal)
    {
        $this->view = $this->view($goal);
    }

    /**
     * @param  string $id
     */
    public function pathNotFound(string $id)
    {
        throw $this->createNotFoundException('Path does not exist');
    }

    /**
     * @param  string $goalId
     */
    public function goalNotFound(string $goalId)
    {
        throw $this->createNotFoundException('Goal does not exist');
    }
}
