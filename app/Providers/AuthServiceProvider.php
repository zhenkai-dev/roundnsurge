<?php

namespace App\Providers;

use App\Banner;
use App\Course;
use App\Invoice;
use App\Member;
use App\Menu;
use App\News;
use App\Package;
use App\Page;
use App\Setting;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Banner::class => 'App\Policies\Admin\BannerPolicy',
        Member::class => 'App\Policies\Admin\MemberPolicy',
        Menu::class => 'App\Policies\Admin\MenuPolicy',
        News::class => 'App\Policies\Admin\NewsPolicy',
        Page::class => 'App\Policies\Admin\PagePolicy',
        Setting::class => 'App\Policies\Admin\SettingPolicy',
        User::class => 'App\Policies\Admin\UserPolicy',

        Course::class => 'App\Policies\Admin\CoursePolicy',
        Package::class => 'App\Policies\Admin\PackagePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->segment(1) === config('app.member_prefix')) {
            $this->policies = [
                Course::class => 'App\Policies\Member\CoursePolicy',
                Invoice::class => 'App\Policies\Member\InvoicePolicy',

                /*Banner::class => 'App\Policies\Member\BannerPolicy',
                Member::class => 'App\Policies\Member\MemberPolicy',
                Menu::class => 'App\Policies\Member\MenuPolicy',
                News::class => 'App\Policies\Member\NewsPolicy',
                Page::class => 'App\Policies\Member\PagePolicy',
                Setting::class => 'App\Policies\Member\SettingPolicy',
                User::class => 'App\Policies\Member\UserPolicy',

                Course::class => 'App\Policies\Member\CoursePolicy',
                Package::class => 'App\Policies\Member\PackagePolicy',*/
            ];
        }

        $this->registerPolicies();

        Passport::routes();
    }
}
