<?php

namespace App\Repositories\Specialized;

use App\Models\Specialized;
use App\Repositories\BaseRepository;

class SpecializedRepository extends BaseRepository implements SpecializedRepositoryInterface
{
  public function getModel()
  {
    return Specialized::class;
  }

}
