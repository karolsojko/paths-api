<?php

namespace Domain\Repository;

use Domain\Model\Path;

interface PathsRepository
{
    public function find($id);

    public function findByUserId($userId);

    public function add(Path $Path);
}
