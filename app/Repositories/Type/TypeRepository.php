<?php

namespace App\Repositories\Type;

use App\Models\Type;
use App\Repositories\BaseRepository;

class TypeRepository extends BaseRepository implements TypeRepositoryInterface
{
  public function getModel()
  {
    return Type::class;
  }

}
