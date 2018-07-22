<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 6/2/2017
 * Time: 12:44 PM
 */

if (!function_exists('currency_code')) {
    function currency_code()
    {
        $currency = array(
            '344' => 'HKD',
            '840' => 'USD',
            '702' => 'SGD',
            '156' => 'CNY',
            '392' => 'JPY',
            '901' => 'TWD',
            '036' => 'AUD',
            '978' => 'EUR',
            '826' => 'GBP',
            '124' => 'CAD',
            '446' => 'MOP',
            '608' => 'PHP',
            '764' => 'THB',
            '458' => 'MYR',
            '360' => 'IDR',
            '410' => 'KRW',
            '682' => 'SAR',
            '554' => 'NZD',
            '784' => 'AED',
            '096' => 'BND',
            '704' => 'VND',
            '356' => 'INR'
        );
        return $currency;
    }
}

if (!function_exists('sortable_link')) {
    /**
     * Get sortable link by given column name, attach with current url request.
     * Sort direction default to asc, and switch to desc if sort request asc found in url.
     *
     * @param string $sortBy name to be sorted
     * @return string generated sortable link
     */
    function sortable_link(string $sortBy)
    {
        return \App\Service\Util\SortUtil::link($sortBy);
    }
}

if (!function_exists('sortable')) {
    /**
     * Get sortable view by given column name, attach with current url request.
     * Sort direction default to asc, and switch to desc if sort request asc found in url.
     *
     * @param string $sortBy record name to be sorted
     * @param string $name column name
     * @return \Illuminate\View\View generated sortable link
     */
    function sortable(string $sortBy, string $name): \Illuminate\View\View
    {
        return \App\Service\Util\SortUtil::sortable($sortBy, $name);
    }
}

if (!function_exists('delete_icon')) {
    /**
     * Get delete icon by boolean
     *
     * @param string $title
     * @return \Illuminate\View\View
     */
    function delete_icon(string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::deleteIcon($title);
    }
}

if (!function_exists('delete_icon_link')) {
    /**
     * Get delete icon by boolean
     *
     * @param string $url
     * @param string $title
     * @return \Illuminate\View\View
     */
    function delete_icon_link(string $url, string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::deleteIconLink($url, $title);
    }
}

if (!function_exists('delete_icon_muted')) {
    /**
     * Get delete icon by boolean
     *
     * @param string $title
     * @return \Illuminate\View\View
     */
    function delete_icon_muted(string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::deleteIconMuted($title);
    }
}

if (!function_exists('edit_icon')) {
    /**
     * Get edit icon by boolean
     *
     * @param string $title
     * @return \Illuminate\View\View
     */
    function edit_icon(string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::editIcon($title);
    }
}

if (!function_exists('edit_icon_link')) {
    /**
     * Get edit icon by boolean
     *
     * @param string $url
     * @param string $title
     * @return \Illuminate\View\View
     */
    function edit_icon_link(string $url, string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::editIconLink($url, $title);
    }
}

if (!function_exists('edit_icon_muted')) {
    /**
     * Get edit icon by boolean
     *
     * @param string $title
     * @return \Illuminate\View\View
     */
    function edit_icon_muted(string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::editIconMuted($title);
    }
}

if (!function_exists('view_icon')) {
    /**
     * Get view icon by boolean
     *
     * @param string $title
     * @return \Illuminate\View\View
     */
    function view_icon(string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::viewIcon($title);
    }
}

if (!function_exists('view_icon_link')) {
    /**
     * Get view icon by boolean
     *
     * @param string $url
     * @param string $title
     * @return \Illuminate\View\View
     */
    function view_icon_link(string $url, string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::viewIconLink($url, $title);
    }
}

if (!function_exists('view_icon_muted')) {
    /**
     * Get view icon by boolean
     *
     * @param string $title
     * @return \Illuminate\View\View
     */
    function view_icon_muted(string $title = ''): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::viewIconMuted($title);
    }
}

if (!function_exists('status_icon')) {
    /**
     * Get status icon by boolean
     *
     * @param bool $status
     * @return \Illuminate\View\View
     */
    function status_icon(bool $status): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::statusIcon($status);
    }
}

if (!function_exists('add_new_button')) {
    /**
     * Get add new button
     *
     * @param string $url
     * @return \Illuminate\View\View
     */
    function add_new_button(string $url): \Illuminate\View\View
    {
        return \App\Service\Util\ViewUtil::addNewButton($url);
    }
}

if (!function_exists('route_type')) {
    /**
     * Get route type extract route name and return only the last extracted part.
     * eg route('admin.user.create') will return 'create'
     *
     * @return string
     */
    function route_type(): string
    {
        return \App\Service\Util\RouteUtil::routeType();
    }
}

if (!function_exists('is_edit')) {
    function is_edit(): bool
    {
        return route_type() == \App\Enumeration\RouteTypeEnum::EDIT;
    }
}

if (!function_exists('is_create')) {
    function is_create(): bool
    {
        return route_type() == \App\Enumeration\RouteTypeEnum::CREATE;
    }
}

if (!function_exists('current_datetime_string')) {
    function current_datetime_string(): string
    {
        return \Carbon\Carbon::now()->format('Y-m-d H:i:s');
    }
}

if (!function_exists('get_link_target_list')) {
    function get_link_target_list(): array
    {
        return \App\Enumeration\LinkTargetEnum::values();
    }
}

if (!function_exists('get_url_list')) {
    function get_url_list(): array
    {
        return \App\Service\Admin\FriendlyUrlService::getUrlList();
    }
}

if (!function_exists('carbon_to_calendar')) {
    function carbon_to_calendar(\Carbon\Carbon $date): string
    {
        return $date->format('m/d/Y');
    }
}

if (!function_exists('get_logo')) {
    function get_logo(): string
    {
        return \Illuminate\Support\Facades\Storage::url(config('storage.directory.setting') . '/logo.svg');
    }
}

if (!function_exists('get_social_cover')) {
    function get_social_cover(): string
    {
        return \Illuminate\Support\Facades\Storage::url(config('storage.directory.setting') . '/cover.png');
    }
}

if (!function_exists('get_site_url')) {
    function get_site_url(\App\Dto\UrlDto $urlDto): string
    {
        return \App\Service\Util\UrlUtil::generateSiteUrl($urlDto);
    }
}

if (!function_exists('is_absolute_url')) {
    function is_absolute_url(string $url): bool
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) == 1;
    }
}

if (!function_exists('setting')) {
    function setting(): \App\Setting
    {
        return app('Setting');
    }
}

if (!function_exists('editor_content')) {
    function editor_content(?string $content): string
    {
        $content = htmlspecialchars_decode($content);
        if ($content != '') {
            $doc = new DOMDocument();
            @$doc->loadHTML($content);
            $linkTags = $doc->getElementsByTagName('a');

            foreach ($linkTags as $tag) {
                $linkHref = $tag->getAttribute('href');

                if (!is_absolute_url($linkHref)) {
                    if (!starts_with($linkHref, '#') && strpos($linkHref, ':') === false) {
                        $content = str_replace('href="' . $linkHref . '"', 'href="' . url($linkHref) . '"', $content);
                    }
                } else {
                    $url = parse_url($linkHref);

                    if (isset($url['scheme']) && starts_with($linkHref, $url['scheme'] . '://files/editor_files/')) {
                        $newLinkHref = str_replace($url['scheme'] . '://', '', $linkHref);
                        $content = str_replace(
                            'href="' . $linkHref . '"',
                            'href="' . url($newLinkHref) . '"',
                            $content
                        );
                    }
                }
            }

            $imgTags = $doc->getElementsByTagName('img');
            foreach ($imgTags as $tag) {
                $imgSrc = $tag->getAttribute('src');
                if (!is_absolute_url($imgSrc)) {
                    $content = str_replace('src="' . $imgSrc . '"', 'src="' . url($imgSrc) . '"', $content);
                }
            }
        }

        return '<div class="editor-content">' . $content . '</div>';
    }
}

if (!function_exists('can_access_module')) {
    function can_access_module(string $model): bool
    {
        try {
            $class = new \ReflectionClass($model);
            return config('app.modules.' . strtolower($class->getShortName())) == true &&
                Auth::user()->can(\App\Enumeration\PolicyActionEnum::INDEX, $model);
        } catch (ReflectionException $e) {
            return false;
        }
    }
}