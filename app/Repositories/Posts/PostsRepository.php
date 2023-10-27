<?php

namespace App\Repositories\Posts;

use App\Models\Post;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class PostsRepository extends BaseRepository implements PostsRepositoryInterface
{
  public function getModel()
  {
    return Post::class;
  }

  public function getPostsOnIndex($request)
  {
    $search = $request->search ?? '';

    $posts = $this->model->where(function ($query) use ($search) {
      $query->where('title', 'like', '%' . $search . '%')
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'like', '%' . $search . '%');
        })
        ->orWhereHas('tags', function ($query) use ($search) {
          $query->where('name', 'like', '%' . $search . '%');
        });
    });

    $posts = $this->filter($posts, $request);
    $posts = $this->sortAndPagination($posts, $request);

    if ($posts->count() == 0) {
      return [];
    }

    return $posts;
  }

  public function getDocumentsOnIndex($request)
  {
    $search = $request->search ?? '';

    $posts = $this->model->where(function ($query) use ($search) {
      $query->where('file_path', '<>', '')
        ->where(function ($query) use ($search) {
          $query->where('title', 'like', '%' . $search . '%')
            ->orWhereHas('user', function ($query) use ($search) {
              $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('tags', function ($query) use ($search) {
              $query->where('name', 'like', '%' . $search . '%');
            });
        });
    });

    $posts = $this->filter($posts, $request);
    $posts = $this->sortAndPagination($posts, $request);

    if ($posts->count() == 0) {
      return [];
    }

    return $posts;
  }

  private function sortAndPagination($posts, Request $request)
  {
    $perPage = 10;
    $sortBy = $request->sort_by ?? 'oldest';

    switch ($sortBy) {
      case 'latest':
        $posts = $posts->orderBy('created_at');
        break;
      case 'oldest':
        $posts = $posts->orderByDesc('created_at');
        break;
      default:
        $posts = $posts->orderBy('created_at');
        break;
    }

    $posts = $posts->paginate($perPage);
    $posts->appends(['sort_by' => $sortBy]);

    return $posts;
  }

  public function filter($posts, Request $request)
  {
    //Lọc theo bộ môn
    $specialized = $request->specialized;
    $posts = $specialized != null
      ? $posts->where('specialized', $specialized)
      : $posts;

    //Lọc theo môn học
    $subject = $request->subject;
    $posts = $subject != null
      ? $posts->where('subject', $subject)
      : $posts;

    //Lọc theo chủ đề
    $topic = $request->topic;
    $posts = $topic != null
      ? $posts->where('topic', $topic)
      : $posts;

    //Lọc theo danh mục
    $category = $request->category;
    $posts = $category != null
      ? $posts->where('category', $category)
      : $posts;

    return $posts;
  }
}
