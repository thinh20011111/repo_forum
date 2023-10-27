<?php

namespace App\Services\PostCategories;

use App\Repositories\PostCategories\PostCategoriesRepositoryInterface;
use App\Services\BaseService;

class PostCategoriesService extends BaseService implements PostCategoriesServiceInterface
{
    public $repository;

    public function __construct(PostCategoriesRepositoryInterface $PostCategoriesRepository)
    {
        $this->repository = $PostCategoriesRepository;
    }

}
