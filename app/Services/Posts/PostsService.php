<?php

namespace App\Services\Posts;

use App\Models\Tag;
use App\Repositories\Posts\PostsRepositoryInterface;
use App\Services\BaseService;

class PostsService extends BaseService implements PostsServiceInterface
{
    public $repository;

    public function __construct(PostsRepositoryInterface $PostsRepository)
    {
        $this->repository = $PostsRepository;
    }

    public function getPostsOnIndex($request)
    {
        return $this->repository->getPostsOnIndex($request);
    }

    public function getDocumentsOnIndex($request)
    {
        return $this->repository->getDocumentsOnIndex($request);
    }


}
