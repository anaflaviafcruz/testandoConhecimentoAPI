<?php

namespace App\Repositories;   

use Illuminate\Database\Eloquent\Model;  
use App\Repositories\UserRepositoryInterface; 
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**      
     * @var Model      
     */     
    protected $model;

    /**
    * UserRepository constructor.
    *
    * @param User $model
    */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}