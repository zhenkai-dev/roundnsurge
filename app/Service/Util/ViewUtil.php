<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 8/1/2018
 * Time: 8:35 AM
 */

namespace App\Service\Util;

use Illuminate\View\View;

class ViewUtil
{
    /**
     * Get status icon view
     *
     * @param bool $status
     * @return View
     */
    public static function statusIcon(bool $status): View
    {
        return view('admin.shared.icon.status-icon-component', ['status' => $status]);
    }

    /**
     * Get add new record button
     *
     * @param string $url link to new form page
     * @return View
     */
    public static function addNewButton(string $url): View
    {
        return view('admin.shared.button.add-new-button-component', ['url' => $url]);
    }

    /**
     * Get edit icon
     *
     * @param string $title
     * @return View
     */
    public static function editIcon(string $title = ''): View
    {
        return view('admin.shared.icon.edit-icon-component', ['title' => $title]);
    }

    /**
     * Get edit icon with redirect link
     *
     * @param string $url
     * @param string $title
     * @return View
     */
    public static function editIconLink(string $url, string $title = ''): View
    {
        return view('admin.shared.icon.edit-icon-link-component', ['url' => $url, 'title' => $title]);
    }

    /**
     * Get muted edit icon
     *
     * @param string $title
     * @return View
     */
    public static function editIconMuted(string $title = ''): View
    {
        return view('admin.shared.icon.edit-icon-muted-component', ['title' => $title]);
    }

    /**
     * Get delete icon
     *
     * @param string $title
     * @return View
     */
    public static function deleteIcon(string $title = ''): View
    {
        return view('admin.shared.icon.delete-icon-component', ['title' => $title]);
    }

    /**
     * Get muted delete icon
     *
     * @param string $title
     * @return View
     */
    public static function deleteIconMuted(string $title = ''): View
    {
        return view('admin.shared.icon.delete-icon-muted-component', ['title' => $title]);
    }

    /**
     * Get delete icon with redirect link
     *
     * @param string $url
     * @param string $title
     * @return View
     */
    public static function deleteIconLink(string $url, string $title = ''): View
    {
        return view('admin.shared.icon.delete-icon-link-component', ['url' => $url, 'title' => $title]);
    }
}