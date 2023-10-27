<?php

namespace App\Repositories\Report;

use App\Models\Report;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    public function getModel()
    {
        return Report::class;
    }

    public function getPostsOnIndex($request)
    {
        $search = $request->search_report ?? '';

        $reports = $this->model->where('type' , 'post')->where(function ($query) use ($search) {
            $query->whereHas('owner', function ($userQuery) use ($search) {
                $userQuery->where('name', 'like', '%' . $search . '%');
            });
        });

        $reports = $this->Pagination($reports, $request);

        if ($reports->count() == 0) {
            return [];
        }

        return $reports;
    }

    public function getCommentsOnIndex($request)
    {
        $search = $request->search_report ?? '';

        $reports = $this->model->where('type' , 'comment')->where(function ($query) use ($search) {
            $query->whereHas('owner', function ($userQuery) use ($search) {
                $userQuery->where('name', 'like', '%' . $search . '%');
            });
        });

        $reports = $this->Pagination($reports, $request);

        if ($reports->count() == 0) {
            return [];
        }

        return $reports;
    }

    private function Pagination($reports)
    {
        $perPage = 10;

        $reports = $reports->orderBy('id', 'desc')->paginate($perPage);

        return $reports;
    }
}
