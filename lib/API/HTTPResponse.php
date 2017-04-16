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

    public function __construct($response) {
        $this->response = $response;
    }

    public function getStatusCode(){

    }

    /**
     * @return array
     */
    public function getResult() {
       return json_decode($this->getResponse()->getBody()->getContents(), true);
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

}
