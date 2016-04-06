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

    public function find($userId)
    {
        return $this->manager->getRepository(Path::class)->find($userId);
    }

    public function add(Path $path)
    {
        $this->manager->persist($path);
        $this->manager->flush();
    }
}
