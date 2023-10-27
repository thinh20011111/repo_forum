<?php

namespace App\Services\Type;

use App\Repositories\Type\TypeRepositoryInterface;
use App\Services\BaseService;

class TypeService extends BaseService implements TypeServiceInterface
{
    public $repository;

    public function __construct(TypeRepositoryInterface $TypeRepository)
    {
        $this->repository = $TypeRepository;
    }

}
