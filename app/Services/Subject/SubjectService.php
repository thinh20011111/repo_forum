<?php

namespace App\Services\Subject;

use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Services\BaseService;

class SubjectService extends BaseService implements SubjectServiceInterface
{
    public $repository;

    public function __construct(SubjectRepositoryInterface $SubjectRepository)
    {
        $this->repository = $SubjectRepository;
    }

}
