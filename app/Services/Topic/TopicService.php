<?php

namespace App\Services\Topic;

use App\Repositories\Topic\TopicRepositoryInterface;
use App\Services\BaseService;

class TopicService extends BaseService implements TopicServiceInterface
{
    public $repository;

    public function __construct(TopicRepositoryInterface $TopicRepository)
    {
        $this->repository = $TopicRepository;
    }

}
