<?php

namespace App\Repositories\PostCategories;

use App\Models\PostCategories;
use App\Repositories\BaseRepository;

class PostCategoriesRepository extends BaseRepository implements PostCategoriesRepositoryInterface
{
  public function getModel()
  {
    return PostCategories::class;
  }

}
