<?php

namespace App\Services\Posts;

use App\Services\ServiceInterface;

interface PostsServiceInterface extends ServiceInterface
{
    public function getPostsOnIndex($request);
    public function getDocumentsOnIndex($request);
}
