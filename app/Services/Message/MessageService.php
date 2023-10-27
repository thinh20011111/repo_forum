<?php

namespace App\Services\Message;

use App\Repositories\Message\MessageRepositoryInterface;
use App\Services\BaseService;

class MessageService extends BaseService implements MessageServiceInterface
{
    public $repository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->repository = $messageRepository;
    }

}
