<?php

namespace AppBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Domain\Model\Path;
use Domain\Model\Goal;
use Domain\Model\Comment;

class LoadPathData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $pathsData = $this->getPathsData();

        foreach ($pathsData as $userId => $pathData) {
            $path = new Path($userId);

            if (!empty($pathData->cards)) {
                foreach ($pathData->cards as $card) {
                    $name = isset($card->type) ? $card->type : '';
                    $description = isset($card->task) ? $card->task : '';
                    $goal = new Goal($name, $description);
                    if (isset($card->order)) {
                        $goal->setOrder($card->order);
                    }
                    if (isset($card->icon)) {
                        $goal->setIcon($card->icon);
                    }
                    if (isset($card->level)) {
                        $goal->setLevel($card->level);
                    }
                    if (isset($card->dueDate)) {
                        $goal->setDueDate($card->dueDate);
                    }
                    if (isset($card->achieved)) {
                        $goal->setAchieved($card->achieved);
                    }
                    if (isset($card->unread)) {
                        $goal->setUnread($card->unread);
                    }
                    if (!empty($card->comments)) {
                        foreach ($card->comments as $commentData) {
                            $comment = new Comment($commentData->author, $commentData->text);
                            $comment->setTimestamp($commentData->timestamp);
                            if (!empty($commentData->replies)) {
                                foreach ($commentData->replies as $replyData) {
                                    $reply = new Comment($replyData->author, $replyData->text);
                                    $reply->setTimestamp($replyData->timestamp);
                                    $comment->addReply($reply);
                                }
                            }
                            $goal->addComment($comment);
                        }
                    }
                    $path->addGoal($goal);
                }
            }

            $manager->persist($path);
            $manager->flush();
        }
    }

    private function getPathsData()
    {
        $pathsData = [];

        $rootDir = $this->container->getParameter('kernel.root_dir');
        if (file_exists($rootDir . '/../var/paths.json')) {
            $pathsData =
                json_decode(file_get_contents($rootDir . '/../var/paths.json'));
        }

        return $pathsData;
    }
}
