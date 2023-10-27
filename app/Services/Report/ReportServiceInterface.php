<?php

namespace App\Services\Report;

use App\Services\ServiceInterface;

interface ReportServiceInterface extends ServiceInterface
{
    public function getPostsOnIndex($request);
    public function getCommentsOnIndex($request);
 
}
