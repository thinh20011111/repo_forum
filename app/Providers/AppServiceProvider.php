<?php

namespace App\Providers;

use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Message\MessageRepository;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\PostCategories\PostCategoriesRepository;
use App\Repositories\PostCategories\PostCategoriesRepositoryInterface;
use App\Repositories\Posts\PostsRepository;
use App\Repositories\Posts\PostsRepositoryInterface;
use App\Repositories\Report\ReportRepository;
use App\Repositories\Report\ReportRepositoryInterface;
use App\Repositories\School_year\School_yearRepository;
use App\Repositories\School_year\School_yearRepositoryInterface;
use App\Repositories\Specialized\SpecializedRepository;
use App\Repositories\Specialized\SpecializedRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Type\TypeRepository;
use App\Repositories\Type\TypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Comment\CommentService;
use App\Services\Comment\CommentServiceInterface;
use App\Services\Message\MessageService;
use App\Services\Message\MessageServiceInterface;
use App\Services\Notification\NotificationService;
use App\Services\Notification\NotificationServiceInterface;
use App\Services\PostCategories\PostCategoriesService;
use App\Services\PostCategories\PostCategoriesServiceInterface;
use App\Services\Posts\PostsService;
use App\Services\Posts\PostsServiceInterface;
use App\Services\Report\ReportService;
use App\Services\Report\ReportServiceInterface;
use App\Services\School_year\School_yearService;
use App\Services\School_year\School_yearServiceInterface;
use App\Services\Specialized\SpecializedService;
use App\Services\Specialized\SpecializedServiceInterface;
use App\Services\Subject\SubjectService;
use App\Services\Subject\SubjectServiceInterface;
use App\Services\Type\TypeService;
use App\Services\Type\TypeServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //User
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            UserServiceInterface::class,
            UserService::class
        );

        //Posts
        $this->app->singleton(
            PostsRepositoryInterface::class,
            PostsRepository::class
        );

        $this->app->singleton(
            PostsServiceInterface::class,
            PostsService::class
        );

        //Types
        $this->app->singleton(
            TypeRepositoryInterface::class,
            TypeRepository::class
        );

        $this->app->singleton(
            TypeServiceInterface::class,
            TypeService::class
        );

        //School Year
        $this->app->singleton(
            School_yearRepositoryInterface::class,
            School_yearRepository::class
        );

        $this->app->singleton(
            School_yearServiceInterface::class,
            School_yearService::class
        );

        //Subject
        $this->app->singleton(
            SubjectRepositoryInterface::class,
            SubjectRepository::class
        );

        $this->app->singleton(
            SubjectServiceInterface::class,
            SubjectService::class
        );

        //Specialized
        $this->app->singleton(
            SpecializedRepositoryInterface::class,
            SpecializedRepository::class
        );

        $this->app->singleton(
            SpecializedServiceInterface::class,
            SpecializedService::class
        );

        //PostCategories
        $this->app->singleton(
            PostCategoriesRepositoryInterface::class,
            PostCategoriesRepository::class
        );

        $this->app->singleton(
            PostCategoriesServiceInterface::class,
            PostCategoriesService::class
        );

        //Comment
        $this->app->singleton(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );

        $this->app->singleton(
            CommentServiceInterface::class,
            CommentService::class
        );

        //Report
        $this->app->singleton(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );

        $this->app->singleton(
            ReportServiceInterface::class,
            ReportService::class
        );

        //Notification
        $this->app->singleton(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );

        $this->app->singleton(
            NotificationServiceInterface::class,
            NotificationService::class
        );

        //Message
        $this->app->singleton(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );

        $this->app->singleton(
            MessageServiceInterface::class,
            MessageService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
