<?php

namespace App\Repositories\School_year;

use App\Models\School_year;
use App\Repositories\BaseRepository;

class School_yearRepository extends BaseRepository implements School_yearRepositoryInterface
{
  public function getModel()
  {
    return School_year::class;
  }

}
