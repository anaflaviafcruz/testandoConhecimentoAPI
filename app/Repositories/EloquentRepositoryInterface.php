<?php   

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/

interface EloquentRepositoryInterface
{
   /**
    * @param array $attributes
    * @return json
    */

   public function create(array $attributes): Model;

}
