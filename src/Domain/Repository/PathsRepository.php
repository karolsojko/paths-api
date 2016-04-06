<?php

namespace Domain\Repository;

use Domain\Model\Path;

interface PathsRepository
{
    public function find($userId);

    public function add(Path $Path);
}
