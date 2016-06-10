<?php

namespace Infrastructure\ODM\Repository;

use Doctrine\Common\Persistence\ObjectManager;
use Domain\Repository\PathsRepository as PathsRepositoryInterface;
use Domain\Model\Path;

class PathsRepository implements PathsRepositoryInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function find($id)
    {
        return $this->manager->getRepository(Path::class)->find($id);
    }

    public function add(Path $path)
    {
        $this->manager->persist($path);
        $this->manager->flush();
    }

    public function findByUserId($userId)
    {
        return $this
            ->manager
            ->getRepository(Path::class)
            ->findBy(['userId' => $userId]);
    }
}
