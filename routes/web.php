<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Front\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Login
Route::prefix('account')->group(function () {
    Route::get('login', [\App\Http\Controllers\Front\AccountController::class, 'login']);
    Route::post('login', [\App\Http\Controllers\Front\AccountController::class, 'checkMemberLogin']);
    Route::get('logout', [\App\Http\Controllers\Front\AccountController::class, 'logout']);
    Route::get('register', [\App\Http\Controllers\Front\AccountController::class, 'register']);
    Route::post('register', [\App\Http\Controllers\Front\AccountController::class, 'postRegister']);
    Route::get('forgot_password', [\App\Http\Controllers\Front\AccountController::class, 'fogot_password']);
    Route::post('send_resset_password', [\App\Http\Controllers\Front\AccountController::class, 'reset_password']);
    Route::get('change_password', [\App\Http\Controllers\Front\AccountController::class, 'change_password']);
    Route::post('change_password', [\App\Http\Controllers\Front\AccountController::class, 'update_password']);
});



//Trang chủ
Route::prefix('/')->group(function () {
    Route::get('',  [\App\Http\Controllers\Front\HomeController::class, 'index']);
    Route::get('/what_news',  [\App\Http\Controllers\Front\HomeController::class, 'what_news']);
    Route::get('/new_images',  [\App\Http\Controllers\Front\HomeController::class, 'new_images']);
    Route::get('/new_documents',  [\App\Http\Controllers\Front\HomeController::class, 'new_documents']);
    Route::get('/new_posts',  [\App\Http\Controllers\Front\HomeController::class, 'new_posts']);
    Route::get('/new_posts/post_{id}',  [\App\Http\Controllers\Front\PostController::class, 'show']);
    Route::get('/new_status',  [\App\Http\Controllers\Front\HomeController::class, 'new_status']);
    Route::post('/new_posts/post_{id}/like',  [\App\Http\Controllers\Front\LikeController::class, 'like'])->middleware('CheckMemberLogin');
    Route::post('/new_posts/post_{id}/comment', [\App\Http\Controllers\Front\CommentController::class, 'comment'])->middleware('CheckMemberLogin');
    Route::post('/new_posts/post_{id}/report_post', [\App\Http\Controllers\Front\ReportController::class, 'report_post'])->middleware('CheckMemberLogin');
    Route::post('/new_posts/post_{id}/report_comment_{comment_id}', [\App\Http\Controllers\Front\ReportController::class, 'report_comment'])->middleware('CheckMemberLogin');
    Route::delete('/new_posts/post_{post_id}/delete_comment_{comment_id}', [\App\Http\Controllers\Front\CommentController::class, 'destroy'])->middleware('CheckMemberLogin');
    Route::get('/new_posts/post_{postId}/comment_count', [\App\Http\Controllers\Front\CommentController::class, 'getCommentCount']);
    Route::post('/new_posts/post_{postId}/update_comment', [\App\Http\Controllers\Front\CommentController::class, 'update'])->middleware('CheckMemberLogin');
    Route::post('/new_posts/post_{postId}/update_post', [\App\Http\Controllers\Front\PostController::class, 'update'])->middleware('CheckMemberLogin');
    Route::delete('/new_posts/post_{postId}/delete_post', [\App\Http\Controllers\Front\PostController::class, 'destroy'])->middleware('CheckMemberLogin');
    Route::post('/create_daily_post', [\App\Http\Controllers\Front\PostController::class, 'create_daily_post'])->middleware('CheckMemberLogin');
    Route::post('/create_new_story', [\App\Http\Controllers\Front\PostController::class, 'create_stories_post'])->middleware('CheckMemberLogin');
    Route::get('/stories_post', [\App\Http\Controllers\Front\HomeController::class, 'stories_post']);
    Route::get('/list_member', [\App\Http\Controllers\Front\HomeController::class, 'list_member']);
    Route::get('/list_follows', [\App\Http\Controllers\Front\HomeController::class, 'list_follow'])->middleware('CheckMemberLogin');
    Route::post('/post_{id}/disable_comment', [\App\Http\Controllers\Front\PostController::class, 'disable_comment'])->middleware('CheckMemberLogin');


    Route::get('/top_member', [\App\Http\Controllers\Front\HomeController::class, 'top_member']);
    Route::get('/top_member/top_like', [\App\Http\Controllers\Front\HomeController::class, 'top_like']);
    Route::get('/top_member/top_post', [\App\Http\Controllers\Front\HomeController::class, 'top_post']);
    Route::get('/top_member/list_admin', [\App\Http\Controllers\Front\HomeController::class, 'list_admin']);
    Route::get('/top_member/birthday_today', [\App\Http\Controllers\Front\HomeController::class, 'birthday_today']);

    Route::get('/online_member', [\App\Http\Controllers\Front\HomeController::class, 'online_member']);

    //follow
    Route::post('/follow/{id}', [\App\Http\Controllers\Front\UserProfileController::class, 'followUser'])->middleware('CheckMemberLogin');
    Route::get('/user-profile-post-{id}', [\App\Http\Controllers\Front\UserProfileController::class, 'user_posts']);
    Route::get('/user-profile-image-{id}', [\App\Http\Controllers\Front\UserProfileController::class, 'user_image']);
    Route::get('/user-profile-stories-{id}', [\App\Http\Controllers\Front\UserProfileController::class, 'user_stories']);


    //Messages
    Route::get('/messages', [\App\Http\Controllers\MessagesController::class, 'index'])->middleware('CheckMemberLogin');
    Route::get('/messages_{id}', [\App\Http\Controllers\MessagesController::class, 'conventions'])->middleware('CheckMemberLogin');

    Route::post('/send-messages', [\App\Http\Controllers\MessagesController::class, 'send'])->middleware('CheckMemberLogin');
    Route::get('/get_messages_{id}', [\App\Http\Controllers\MessagesController::class, 'get_messages'])->middleware('CheckMemberLogin');
    Route::get('/search_user', [\App\Http\Controllers\MessagesController::class, 'search'])->middleware('CheckMemberLogin');

    Route::get('/notifications', [\App\Http\Controllers\Front\HomeController::class, 'notifications'])->middleware('CheckMemberLogin');
    Route::post('/notifications/read_all', [\App\Http\Controllers\Front\HomeController::class, 'read_all_notification'])->middleware('CheckMemberLogin');

    Route::post('/update-user-photo', [\App\Http\Controllers\Front\UserProfileController::class, 'updateCoverPhoto']);
    Route::get('/user-profile-edit-{id}', [\App\Http\Controllers\Front\UserProfileController::class, 'user_edit'])->middleware('CheckMemberLogin');
    Route::post('/update_profie', [\App\Http\Controllers\Front\UserProfileController::class, 'update_profie'])->middleware('CheckMemberLogin');
    Route::post('/update_password', [\App\Http\Controllers\Front\UserProfileController::class, 'updatePassword'])->middleware('CheckMemberLogin');
});

Route::prefix('create_post')->middleware('CheckMemberLogin')->group(function () {
    Route::redirect('', 'front/index');
    Route::resource('', App\Http\Controllers\Front\PostController::class); //xử lý thêm bài đăng
});

//Admin
Route::prefix('admin')->middleware('CheckAdminLogin')->group(function () {
    //Trang chủ
    Route::redirect('', 'admin');
    Route::resource('', \App\Http\Controllers\Admin\DashboardController::class); //trang chủ admin

    //school_year
    Route::get('school_years', [App\Http\Controllers\Admin\DashboardController::class, 'school_years']);
    Route::post('school_years/add', [App\Http\Controllers\Admin\SchoolYearController::class, 'store']);
    Route::get('school_years/update_{id}', [App\Http\Controllers\Admin\SchoolYearController::class, 'edit']);
    Route::get('school_years/add', [App\Http\Controllers\Admin\SchoolYearController::class, 'create']);
    Route::post('school_years/add', [App\Http\Controllers\Admin\SchoolYearController::class, 'store']);

    Route::put('school_years/update/{id}', [App\Http\Controllers\Admin\SchoolYearController::class, 'update'])->name('school_years.update');
    Route::delete('school_years/delete/{id}', [App\Http\Controllers\Admin\SchoolYearController::class, 'destroy']);

    Route::get('messages', [App\Http\Controllers\Admin\DashboardController::class, 'messages']);

    Route::get('notification', [App\Http\Controllers\Admin\DashboardController::class, 'notification']);

    //Manage
    Route::get('manage_posts', [App\Http\Controllers\Admin\DashboardController::class, 'manage_posts']);
    Route::get('manage_users', [App\Http\Controllers\Admin\DashboardController::class, 'manage_users']);
    Route::get('manage_event', [App\Http\Controllers\Admin\DashboardController::class, 'manage_event']);
    Route::get('manage_reports/posts', [App\Http\Controllers\Admin\DashboardController::class, 'manage_report_posts']);
    Route::get('manage_reports/comments', [App\Http\Controllers\Admin\DashboardController::class, 'manage_report_comments']);

    //Show report
    Route::get('manage_reports/posts/report_{id}', [App\Http\Controllers\Admin\ReportController::class, 'show']);
    Route::get('search_reports', [App\Http\Controllers\Admin\ReportController::class, 'searchReports']);
    Route::delete('manage_reports/posts/report_{id}', [App\Http\Controllers\Admin\ReportController::class, 'delete']);

    //Delete post or comment
    Route::delete('manage_reports/posts/delete_post_{id}', [App\Http\Controllers\Admin\ReportController::class, 'delete_post']);
    Route::delete('manage_reports/comments/delete_comment_{id}', [App\Http\Controllers\Admin\ReportController::class, 'delete_comment']);

    //Show post
    Route::get('manage_posts/post_{id}', [App\Http\Controllers\Admin\PostController::class, 'show']);
    Route::delete('manage_posts/post_{id}/delete_post', [App\Http\Controllers\Admin\PostController::class, 'delete_post']);
    Route::delete('manage_posts/post_{id}/delete_comment', [App\Http\Controllers\Admin\PostController::class, 'delete_comment']);

    Route::get('manage_event/create_event', [App\Http\Controllers\Admin\PostController::class, 'create_event']);
    Route::post('manage_event/create_event', [App\Http\Controllers\Admin\PostController::class, 'store_event']);
    Route::get('manage_event/event_{id}', [App\Http\Controllers\Admin\PostController::class, 'show_event']);

    Route::delete('manage_event/event_{id}/delete_post', [App\Http\Controllers\Admin\PostController::class, 'delete_event']);
    Route::get('manage_event/search', [App\Http\Controllers\Admin\PostController::class, 'search_event']);//Tìm kiếm sự kiện 
    Route::get('manage_event/search_by_date', [App\Http\Controllers\Admin\PostController::class, 'search_event_by_date']);//Tìm kiếm sự kiện 
    Route::get('manage_event/edit_{id}', [App\Http\Controllers\Admin\PostController::class, 'edit_event']);
    Route::post('manage_event/edit_{id}', [App\Http\Controllers\Admin\PostController::class, 'save_event']);

    //Show user
    Route::get('manage_users/user_{id}', [App\Http\Controllers\Admin\UserController::class, 'show']);
    Route::get('manage_users/edit_{id}', [App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::post('manage_users/edit_{id}', [App\Http\Controllers\Admin\UserController::class, 'update']);
    Route::delete('manage_users/delete_{userId}', [App\Http\Controllers\Admin\UserController::class, 'delete']);

    //Manage subject
    Route::get('manage_subject', [App\Http\Controllers\Admin\DashboardController::class, 'manage_subject']);
    Route::get('manage_subject/subject_{id}', [App\Http\Controllers\Admin\SubjectController::class, 'edit']);
    Route::put('manage_subject/subject_{id}', [App\Http\Controllers\Admin\SubjectController::class, 'update']);
    Route::get('manage_subject/create_subject', [App\Http\Controllers\Admin\SubjectController::class, 'create']);
    Route::post('manage_subject/create_subject', [App\Http\Controllers\Admin\SubjectController::class, 'store']);
    Route::delete('manage_subject/delete_{id}', [App\Http\Controllers\Admin\SubjectController::class, 'destroy']);


    Route::get('search_user', [App\Http\Controllers\Admin\UserController::class, 'searchUser']);

    //Create user
    Route::get('manage_users/create_user', [App\Http\Controllers\Admin\UserController::class, 'create']);
    Route::post('manage_users/create_user', [App\Http\Controllers\Admin\UserController::class, 'store']);


    //Đăng nhập
    Route::prefix('login')->group(function () {
        Route::get('', [\App\Http\Controllers\Admin\DashboardController::class, 'login'])->withoutMiddleware('CheckAdminLogin');
        Route::post('', [App\Http\Controllers\Admin\DashboardController::class, 'checkAdminLogin'])->withoutMiddleware('CheckAdminLogin');
    });

    //Đăng xuất
    Route::get('logout', [App\Http\Controllers\Admin\DashboardController::class, 'logout']);
});
