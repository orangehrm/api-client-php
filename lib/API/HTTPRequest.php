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


class HTTPRequest
{
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
    private function setEndPoint($endPoint)
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
    private function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsShortUrl()
    {
        return $this->isShortUrl;
    }

    /**
     * @param boolean $isShortUrl
     * @return $this;
     */
    private function setIsShortUrl($isShortUrl)
    {
        $this->isShortUrl = $isShortUrl;
        return $this;
    }
}
