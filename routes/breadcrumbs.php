<?php

use App\Banner;
use App\BannerTranslation;
use App\Course;
use App\CourseTranslation;
use App\Member;
use App\Menu;
use App\MenuTranslation;
use App\Package;
use App\PackageTranslation;
use App\Page;
use App\PageTranslation;
use App\News;
use App\NewsTranslation;
use App\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

try {
    Breadcrumbs::register('admin.home', function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('admin.home'));
    });

    Breadcrumbs::register('admin.account.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(__('account.profile'), route('admin.account.index'));
    });

    Breadcrumbs::register('admin.password.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(__('passwords.change'), route('admin.password.index'));
    });

    Breadcrumbs::register('admin.banner.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.banner', 2), route('admin.banner.index'));
    });

    Breadcrumbs::register('admin.banner.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.banner.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.banner.create'));
    });

    Breadcrumbs::register('admin.banner.edit', function (BreadcrumbsGenerator $breadcrumbs, Banner $banner) {
        $breadcrumbs->parent('admin.banner.index');
        /* @var BannerTranslation $bannerTranslation */
        $bannerTranslation = $banner->bannerTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $bannerTranslation->getName()]), route('admin.banner.edit', $banner->getId())
        );
    });

    Breadcrumbs::register('admin.page.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.page', 2), route('admin.page.index'));
    });

    Breadcrumbs::register('admin.page.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.page.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.page.create'));
    });

    Breadcrumbs::register('admin.page.edit', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
        $breadcrumbs->parent('admin.page.index');
        /* @var PageTranslation $pageTranslation */
        $pageTranslation = $page->pageTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $pageTranslation->getName()]), route('admin.page.edit', $page->getId())
        );
    });

    Breadcrumbs::register('admin.news.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.news', 2), route('admin.news.index'));
    });

    Breadcrumbs::register('admin.news.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.news.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.news.create'));
    });

    Breadcrumbs::register('admin.news.edit', function (BreadcrumbsGenerator $breadcrumbs, News $news) {
        $breadcrumbs->parent('admin.news.index');
        /* @var NewsTranslation $newsTranslation */
        $newsTranslation = $news->newsTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $newsTranslation->getName()]), route('admin.news.edit', $news->getId())
        );
    });

    Breadcrumbs::register('admin.menu.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.menu', 2), route('admin.menu.index'));
    });

    Breadcrumbs::register('admin.menu.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.menu.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.menu.create'));
    });

    Breadcrumbs::register('admin.menu.edit', function (BreadcrumbsGenerator $breadcrumbs, Menu $menu) {
        $breadcrumbs->parent('admin.menu.index');
        /* @var MenuTranslation $menuTranslation */
        $menuTranslation = $menu->menuTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $menuTranslation->getName()]), route('admin.menu.edit', $menu->getId())
        );
    });

    Breadcrumbs::register('admin.user.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.user', 2), route('admin.user.index'));
    });

    Breadcrumbs::register('admin.user.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.user.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.user.create'));
    });

    Breadcrumbs::register('admin.user.edit', function (BreadcrumbsGenerator $breadcrumbs, User $user) {
        $breadcrumbs->parent('admin.user.index');
        $breadcrumbs->push(__('form.edit_record', ['name' => $user->getName()]), route('admin.user.edit', $user->getId()));
    });

    Breadcrumbs::register('admin.member.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.member', 2), route('admin.member.index'));
    });

    Breadcrumbs::register('admin.member.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.member.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.member.create'));
    });

    Breadcrumbs::register('admin.member.edit', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
        $breadcrumbs->parent('admin.member.index');
        $breadcrumbs->push(
            __('form.edit_record',
                ['name' => $member->getName()]),
            route('admin.member.edit', $member->getId())
        );
    });

    Breadcrumbs::register('admin.setting.edit', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(__(
            'form.edit_record',
            ['name' => trans_choice('entity.setting', 1)]),
            route('admin.setting.edit')
        );
    });

    Breadcrumbs::register('admin.package.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.package', 2), route('admin.package.index'));
    });

    Breadcrumbs::register('admin.package.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.package.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.package.create'));
    });

    Breadcrumbs::register('admin.package.edit', function (BreadcrumbsGenerator $breadcrumbs, Package $package) {
        $breadcrumbs->parent('admin.package.index');
        /* @var PackageTranslation $packageTranslation */
        $packageTranslation = $package->packageTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $packageTranslation->getName()]), route('admin.package.edit', $package->getId())
        );
    });

    Breadcrumbs::register('admin.course.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans_choice('entity.course', 2), route('admin.course.index'));
    });

    Breadcrumbs::register('admin.course.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('admin.course.index');
        $breadcrumbs->push(__('form.add_new_record'), route('admin.course.create'));
    });

    Breadcrumbs::register('admin.course.edit', function (BreadcrumbsGenerator $breadcrumbs, Course $course) {
        $breadcrumbs->parent('admin.course.index');
        /* @var CourseTranslation $courseTranslation */
        $courseTranslation = $course->courseTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $courseTranslation->getName()]), route('admin.course.edit', $course->getId())
        );
    });
} catch (\DaveJamesMiller\Breadcrumbs\Facades\DuplicateBreadcrumbException $e) {
}

try {
    Breadcrumbs::register('member.home', function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('member.home'));
    });

    Breadcrumbs::register('member.account.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(__('account.profile'), route('member.account.index'));
    });

    Breadcrumbs::register('member.account.membership', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(__('account.membership'), route('member.account.membership'));
    });

    Breadcrumbs::register('member.password.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(__('passwords.change'), route('member.password.index'));
    });

    Breadcrumbs::register('member.banner.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.banner', 2), route('member.banner.index'));
    });

    Breadcrumbs::register('member.banner.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.banner.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.banner.create'));
    });

    Breadcrumbs::register('member.banner.edit', function (BreadcrumbsGenerator $breadcrumbs, Banner $banner) {
        $breadcrumbs->parent('member.banner.index');
        /* @var BannerTranslation $bannerTranslation */
        $bannerTranslation = $banner->bannerTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $bannerTranslation->getName()]), route('member.banner.edit', $banner->getId())
        );
    });

    Breadcrumbs::register('member.page.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.page', 2), route('member.page.index'));
    });

    Breadcrumbs::register('member.page.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.page.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.page.create'));
    });

    Breadcrumbs::register('member.page.edit', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
        $breadcrumbs->parent('member.page.index');
        /* @var PageTranslation $pageTranslation */
        $pageTranslation = $page->pageTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $pageTranslation->getName()]), route('member.page.edit', $page->getId())
        );
    });

    Breadcrumbs::register('member.news.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.news', 2), route('member.news.index'));
    });

    Breadcrumbs::register('member.news.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.news.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.news.create'));
    });

    Breadcrumbs::register('member.news.edit', function (BreadcrumbsGenerator $breadcrumbs, News $news) {
        $breadcrumbs->parent('member.news.index');
        /* @var NewsTranslation $newsTranslation */
        $newsTranslation = $news->newsTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $newsTranslation->getName()]), route('member.news.edit', $news->getId())
        );
    });

    Breadcrumbs::register('member.menu.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.menu', 2), route('member.menu.index'));
    });

    Breadcrumbs::register('member.menu.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.menu.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.menu.create'));
    });

    Breadcrumbs::register('member.menu.edit', function (BreadcrumbsGenerator $breadcrumbs, Menu $menu) {
        $breadcrumbs->parent('member.menu.index');
        /* @var MenuTranslation $menuTranslation */
        $menuTranslation = $menu->menuTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $menuTranslation->getName()]), route('member.menu.edit', $menu->getId())
        );
    });

    Breadcrumbs::register('member.user.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.user', 2), route('member.user.index'));
    });

    Breadcrumbs::register('member.user.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.user.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.user.create'));
    });

    Breadcrumbs::register('member.user.edit', function (BreadcrumbsGenerator $breadcrumbs, User $user) {
        $breadcrumbs->parent('member.user.index');
        $breadcrumbs->push(__('form.edit_record', ['name' => $user->getName()]), route('member.user.edit', $user->getId()));
    });

    Breadcrumbs::register('member.member.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.member', 2), route('member.member.index'));
    });

    Breadcrumbs::register('member.member.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.member.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.member.create'));
    });

    Breadcrumbs::register('member.member.edit', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
        $breadcrumbs->parent('member.member.index');
        $breadcrumbs->push(
            __('form.edit_record',
                ['name' => $member->getName()]),
            route('member.member.edit', $member->getId())
        );
    });

    Breadcrumbs::register('member.setting.edit', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(__(
            'form.edit_record',
            ['name' => trans_choice('entity.setting', 1)]),
            route('member.setting.edit')
        );
    });

    Breadcrumbs::register('member.package.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.package', 2), route('member.package.index'));
    });

    Breadcrumbs::register('member.package.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.package.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.package.create'));
    });

    Breadcrumbs::register('member.package.edit', function (BreadcrumbsGenerator $breadcrumbs, Package $package) {
        $breadcrumbs->parent('member.package.index');
        /* @var PackageTranslation $packageTranslation */
        $packageTranslation = $package->packageTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $packageTranslation->getName()]), route('member.package.edit', $package->getId())
        );
    });

    Breadcrumbs::register('member.course.index', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.home');
        $breadcrumbs->push(trans_choice('entity.course', 2), route('member.course.index'));
    });

    Breadcrumbs::register('member.course.create', function (BreadcrumbsGenerator $breadcrumbs) {
        $breadcrumbs->parent('member.course.index');
        $breadcrumbs->push(__('form.add_new_record'), route('member.course.create'));
    });

    Breadcrumbs::register('member.course.edit', function (BreadcrumbsGenerator $breadcrumbs, Course $course) {
        $breadcrumbs->parent('member.course.index');
        /* @var CourseTranslation $courseTranslation */
        $courseTranslation = $course->courseTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $courseTranslation->getName()]), route('member.course.edit', $course->getId())
        );
    });

    Breadcrumbs::register('member.course.show', function (BreadcrumbsGenerator $breadcrumbs, Course $course) {
        $breadcrumbs->parent('member.course.index');
        /* @var CourseTranslation $courseTranslation */
        $courseTranslation = $course->courseTranslation(app('Language')->getId())->first();
        $breadcrumbs->push(
            __('form.edit_record', ['name' => $courseTranslation->getName()]), route('member.course.show', $course->getId())
        );
    });
} catch (\DaveJamesMiller\Breadcrumbs\Facades\DuplicateBreadcrumbException $e) {
}