<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

namespace Orangehrm\API;


class HTTPRequest {
    const INDEX_PATH = '/symfony/web/index.php';
    const GET_TOKEN_END_POINT = 'oauth/issueToken';

    /**
     * @var string EndPoint
     */
    private $endPoint = null;

    /**
     * @var Params
     */
    private $params = array();

    /**
     * @var bool
     */
    private $isShortUrl = false;

    /**
     * @var string
     */
    private $apiVersion = 'v1';

    /**
     * @var string
     */
    private $basePath = '';

    /**
     * HTTPRequest constructor.
     * @param null $endPoint
     * @param null $params
     */
    public function __construct($endPoint = null , $params = null) {
        $this->setEndPoint($endPoint)
            ->setParams($params);
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @param string $endPoint
     * @return $this;
     */
    public function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;
        return $this;
    }

    /**
     * @return Params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param Params $params
     * @return $this;
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isShortUrl()
    {
        return $this->isShortUrl;
    }

    /**
     * @param boolean $isShortUrl
     * @return $this;
     */
    public function setIsShortUrl($isShortUrl)
    {
        $this->isShortUrl = $isShortUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     * @return $this;
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * @return string
     */
    public function buildEndPoint(){
        $indexPath = null ;
        if(!$this->isShortUrl()){
            $indexPath = self::INDEX_PATH;
        }
        return $this->getBasePath().$indexPath.'/api/'.$this->getApiVersion().'/'.$this->getEndPoint();

    }

    /**
     * @return string
     */
    public function getTokenEndPoint() {
        if($this->isShortUrl()){
            return self::GET_TOKEN_END_POINT;
        }
        return $this->getBasePath().self::INDEX_PATH.'/'.self::GET_TOKEN_END_POINT;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param string $apiVersion
     * @return $this;
     */
    private function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }
}
