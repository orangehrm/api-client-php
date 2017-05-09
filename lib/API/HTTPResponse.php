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

class HTTPResponse {

    private $response = null ;

    private $statusCode = 200;

    private $result = null;

    public function __construct($response) {
        $this->response = $response;
    }

    /**
     * @return null
     */
    public function getStatusCode()
    {
        $result = $this->getResult();
        if(isset($result['error'])) {
            return $result['error']['status'];
        } else{
            return $this->statusCode;
        }

    }

    /**
     * @param null $statusCode
     * @return $this;
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getResult() {
        if(empty($this->result)){
            $this->result = json_decode($this->getResponse()->getBody()->getContents(), true);
        }
       return $this->result ;
    }

    /**
     * @return null
     */
    private function getResponse()
    {
        return $this->response;
    }

    /**
     * Extract Token
     * @return mixed
     */
    public function getToken() {
        $result = $this->getResult();
        if(isset($result['access_token'])){
            return $result['access_token'];
        }
    }

    public function hasError() {

        $result = $this->getResult();
        return isset($result['error']);
    }

    public function getError() {
        $result = $this->getResult();
        if(isset($result['error'])) {
            return $result['error']['text'];
        }

    }

}
