<?php

namespace App\Services\Specialized;

use App\Repositories\Specialized\SpecializedRepositoryInterface;
use App\Services\BaseService;

class SpecializedService extends BaseService implements SpecializedServiceInterface
{
    public $repository;

    public function __construct(SpecializedRepositoryInterface $SpecializedRepository)
    {
        $this->repository = $SpecializedRepository;
    }

}
