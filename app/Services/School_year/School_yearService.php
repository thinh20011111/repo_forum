<?php

namespace App\Services\School_year;

use App\Repositories\School_year\School_yearRepositoryInterface;
use App\Services\BaseService;

class School_yearService extends BaseService implements School_yearServiceInterface
{
    public $repository;

    public function __construct(School_yearRepositoryInterface $TypeRepository)
    {
        $this->repository = $TypeRepository;
    }

}
