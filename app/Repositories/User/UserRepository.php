<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  public function getModel()
  {
    return User::class;
  }

  public function getUserOnIndex($request)
  {
    $search = $request->search_member ?? '';

    $users = $this->model->where(function ($query) use ($search) {
      $query->where('name', 'like', '%' . $search . '%')
        ->orWhere('email', 'like', '%' . $search . '%');
    });

    $users = $users->paginate(20);

    if ($users->count() == 0) {
      return [];
    }

    return $users;
  }
}
