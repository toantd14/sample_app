<?php

namespace App\Providers;

use App\Models\QuestionCategory;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\UserRepository as BridgeUserRepository;
use Modules\Admin\Repositories\MstUser\AdminUserRepository;
use Modules\Admin\Repositories\MstUser\AdminUserRepositoryInterface;
use Modules\Admin\Repositories\OwnerBank\AdminOwnerBankRepository;
use Modules\Admin\Repositories\OwnerBank\AdminOwnerBankRepositoryInterface;
use Modules\Admin\Repositories\OwnerPass\AdminOwnerPassRepository;
use Modules\Admin\Repositories\OwnerPass\AdminOwnerPassRepositoryInterface;
use Modules\Admin\Repositories\UseSituation\AdminUseSituationRepository;
use Modules\Admin\Repositories\UseSituation\AdminUseSituationRepositoryInterface;
use Modules\Api\Repositories\LoginToken\LoginTokenRepository;
use Modules\Api\Repositories\LoginToken\LoginTokenRepositoryInterface;
use Modules\Api\Repositories\MstUser\MstUserRepository;
use Modules\Api\Repositories\MstUser\MstUserRepositoryInterface;
use Modules\Api\Repositories\Parking\ApiParkingLotRepository;
use Modules\Api\Repositories\Parking\ApiParkingLotRepositoryInterface;
use Modules\Api\Repositories\Question\ApiQuestionRepository;
use Modules\Api\Repositories\Question\ApiQuestionRepositoryInterface;
use Modules\Api\Repositories\QuestionCategory\ApiQuestionCategoryRepository;
use Modules\Api\Repositories\QuestionCategory\ApiQuestionCategoryRepositoryInterface;
use Modules\Api\Repositories\Review\ApiReviewRepository;
use Modules\Api\Repositories\Favorite\ApiFavoriteRepository;
use Modules\Api\Repositories\Favorite\ApiFavoriteRepositoryInterface;
use Modules\Api\Repositories\Review\ApiReviewRepositoryInterface;
use Modules\Api\Repositories\UseTerm\UseTermRepository;
use Modules\Api\Repositories\UseTerm\UseTermRepositoryInterface;
use Modules\Owner\Repositories\AdminNotice\AdminNoticeRepository;
use Modules\Owner\Repositories\AdminNotice\AdminNoticeRepositoryInterface;
use Modules\Owner\Repositories\Auth\AuthRepository;
use Modules\Owner\Repositories\Auth\AuthRepositoryInterface;
use Modules\Owner\Repositories\Owner\OwnerRepository;
use Modules\Owner\Repositories\Owner\OwnerRepositoryInterface;
use Modules\Owner\Repositories\OwnerBank\OwnerBankRepository;
use Modules\Owner\Repositories\OwnerBank\OwnerBankRepositoryInterface;
use Modules\Owner\Repositories\OwnerNotice\OwnerNoticeRepository;
use Modules\Owner\Repositories\OwnerNotice\OwnerNoticeRepositoryInterface;
use Modules\Owner\Repositories\OwnerPass\OwnerPassRepository;
use Modules\Owner\Repositories\OwnerPass\OwnerPassRepositoryInterface;
use Modules\Owner\Repositories\Parking\ParkingLotRepository;
use Modules\Owner\Repositories\Parking\ParkingLotRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenuTime\ParkingMenuTimeRepository;
use Modules\Owner\Repositories\ParkingMenuTime\ParkingMenuTimeRepositoryInterface;
use Modules\Owner\Repositories\ParkingSpace\ParkingSpaceRepository;
use Modules\Owner\Repositories\ParkingSpace\ParkingSpaceRepositoryInterface;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepository;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepository;
use Modules\Owner\Repositories\Prefecture\PrefectureRepositoryInterface;
use Modules\Owner\Repositories\UseSituation\UseSituationRepository;
use Modules\Owner\Repositories\UseSituation\UseSituationRepositoryInterface;
use Modules\Owner\Repositories\MstUser\UserRepository;
use Modules\Owner\Repositories\MstUser\UserRepositoryInterface;
use Modules\Admin\Repositories\Admin\AdminRepository;
use Modules\Admin\Repositories\Admin\AdminRepositoryInterface;
use Modules\Admin\Repositories\Parking\AdminParkingLotRepository;
use Modules\Admin\Repositories\Parking\AdminParkingLotRepositoryInterface;
use Modules\Admin\Repositories\Prefecture\AdminPrefectureRepository;
use Modules\Admin\Repositories\Prefecture\AdminPrefectureRepositoryInterface;
use Modules\Admin\Repositories\Owner\AdminOwnerRepository;
use Modules\Admin\Repositories\Owner\AdminOwnerRepositoryInterface;
use Modules\Admin\Repositories\ParkingMenu\AdminParkingMenuRepository;
use Modules\Admin\Repositories\ParkingMenu\AdminParkingMenuRepositoryInterface;
use Modules\Admin\Repositories\ParkingMenuTime\AdminParkingMenuTimeRepository;
use Modules\Admin\Repositories\ParkingMenuTime\AdminParkingMenuTimeRepositoryInterface;
use Modules\Admin\Repositories\ParkingSpace\AdminParkingSpaceRepository;
use Modules\Admin\Repositories\ParkingSpace\AdminParkingSpaceRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            OwnerPassRepositoryInterface::class,
            OwnerPassRepository::class
        );

        $this->app->singleton(
            OwnerRepositoryInterface::class,
            OwnerRepository::class
        );

        $this->app->singleton(
            OwnerNoticeRepositoryInterface::class,
            OwnerNoticeRepository::class
        );

        $this->app->singleton(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );

        $this->app->singleton(
            ParkingLotRepositoryInterface::class,
            ParkingLotRepository::class
        );

        $this->app->singleton(
            ParkingSpaceRepositoryInterface::class,
            ParkingSpaceRepository::class
        );

        $this->app->singleton(
            ParkingMenuRepositoryInterface::class,
            ParkingMenuRepository::class
        );

        $this->app->singleton(
            ParkingMenuTimeRepositoryInterface::class,
            ParkingMenuTimeRepository::class
        );

        $this->app->singleton(
            UseSituationRepositoryInterface::class,
            UseSituationRepository::class
        );

        $this->app->singleton(
            MstUserRepositoryInterface::class,
            MstUserRepository::class
        );

        $this->app->singleton(
            LoginTokenRepositoryInterface::class,
            LoginTokenRepository::class
        );

        $this->app->singleton(
            ApiParkingLotRepositoryInterface::class,
            ApiParkingLotRepository::class
        );

        $this->app->singleton(
            ApiReviewRepositoryInterface::class,
            ApiReviewRepository::class
        );

        $this->app->singleton(
            ApiFavoriteRepositoryInterface::class,
            ApiFavoriteRepository::class
        );

        $this->app->singleton(
            PrefectureRepositoryInterface::class,
            PrefectureRepository::class
        );

        $this->app->singleton(
            ApiReviewRepositoryInterface::class,
            ApiReviewRepository::class
        );

        $this->app->singleton(
            UseTermRepositoryInterface::class,
            UseTermRepository::class
        );

        $this->app->singleton(
            OwnerBankRepositoryInterface::class,
            OwnerBankRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );

        $this->app->singleton(
            AdminNoticeRepositoryInterface::class,
            AdminNoticeRepository::class
        );

        $this->app->singleton(
            AdminParkingLotRepositoryInterface::class,
            AdminParkingLotRepository::class
        );

        $this->app->singleton(
            AdminPrefectureRepositoryInterface::class,
            AdminPrefectureRepository::class
        );

        $this->app->singleton(
            AdminOwnerRepositoryInterface::class,
            AdminOwnerRepository::class
        );

        $this->app->singleton(
            AdminParkingMenuRepositoryInterface::class,
            AdminParkingMenuRepository::class
        );

        $this->app->singleton(
            AdminParkingMenuTimeRepositoryInterface::class,
            AdminParkingMenuTimeRepository::class
        );

        $this->app->singleton(
            AdminUseSituationRepositoryInterface::class,
            AdminUseSituationRepository::class
        );

        $this->app->singleton(
            AdminParkingSpaceRepositoryInterface::class,
            AdminParkingSpaceRepository::class
        );

        $this->app->singleton(
            AdminOwnerBankRepositoryInterface::class,
            AdminOwnerBankRepository::class
        );

        $this->app->singleton(
             AdminOwnerPassRepositoryInterface::class,
            AdminOwnerPassRepository::class
        );

        $this->app->singleton(
            ApiQuestionCategoryRepositoryInterface::class,
            ApiQuestionCategoryRepository::class
        );

        $this->app->singleton(
            ApiQuestionRepositoryInterface::class,
            ApiQuestionRepository::class
        );

        $this->app->singleton(
            AdminUserRepositoryInterface::class,
            AdminUserRepository::class
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
