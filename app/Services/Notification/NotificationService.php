<?php

namespace App\Services\Notification;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Services\BaseService;

class NotificationService extends BaseService implements NotificationServiceInterface
{
    public $repository;

    public function __construct(NotificationRepositoryInterface $NotificationRepository)
    {
        $this->repository = $NotificationRepository;
    }

}
