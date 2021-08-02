<?php

namespace App\Repositories;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{

    /**
    * @param $id
    * @return 
    */
    public function findOrFail(int $id);
}