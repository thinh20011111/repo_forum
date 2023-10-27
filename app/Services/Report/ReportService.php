<?php

namespace App\Services\Report;

use App\Repositories\Report\ReportRepositoryInterface;
use App\Services\BaseService;

class ReportService extends BaseService implements ReportServiceInterface
{
    public $repository;

    public function __construct(ReportRepositoryInterface $ReportRepository)
    {
        $this->repository = $ReportRepository;
    }

    public function getPostsOnIndex($request)
    {
        return $this->repository->getPostsOnIndex($request);
    }

    public function getCommentsOnIndex($request)
    {
        return $this->repository->getCommentsOnIndex($request);
    }
}
