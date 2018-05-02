<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 15/4/2018
 * Time: 2:45 PM
 */

namespace App\Dto;


class UrlDto
{
    private $friendlyUrlId;
    private $friendlyUrlName;
    private $friendlyUrlModule;
    private $url;

    public function __construct($friendlyUrlId, $friendlyUrlName, $friendlyUrlModule, $url)
    {
        $this->friendlyUrlId = $friendlyUrlId;
        $this->friendlyUrlName = $friendlyUrlName;
        $this->friendlyUrlModule = $friendlyUrlModule;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getFriendlyUrlId()
    {
        return $this->friendlyUrlId;
    }

    /**
     * @param mixed $friendlyUrlId
     */
    public function setFriendlyUrlId($friendlyUrlId): void
    {
        $this->friendlyUrlId = $friendlyUrlId;
    }

    /**
     * @return mixed
     */
    public function getFriendlyUrlName()
    {
        return $this->friendlyUrlName;
    }

    /**
     * @param mixed $friendlyUrlName
     */
    public function setFriendlyUrlName($friendlyUrlName): void
    {
        $this->friendlyUrlName = $friendlyUrlName;
    }

    /**
     * @return mixed
     */
    public function getFriendlyUrlModule()
    {
        return $this->friendlyUrlModule;
    }

    /**
     * @param mixed $friendlyUrlModule
     */
    public function setFriendlyUrlModule($friendlyUrlModule): void
    {
        $this->friendlyUrlModule = $friendlyUrlModule;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }


}