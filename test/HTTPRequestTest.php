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

use Orangehrm\API\HTTPRequest;

class HTTPRequestTest extends PHPUnit_Framework_TestCase {
    /**
     * @var HTTPRequest
     */
    protected $httpRequest = null;

    protected function setUp() {
        $this->httpRequest = new HTTPRequest();
    }

    public function testBuildEndPointWhenEmployeeEndPoint() {
        $this->httpRequest->setEndPoint('employee/search');
        $result = $this->httpRequest->buildEndPoint();
        $this->assertEquals('/index.php/api/v1/employee/search',$result);
    }

    public function testGetTokenEndPoint() {

        $result = $this->httpRequest->getTokenEndPoint();
        $this->assertEquals('/index.php/oauth/issueToken',$result);
    }

    public function testBuildEndPointWhenEmployeeEndPointWithCustomIndexPath() {
        $this->httpRequest->setEndPoint('employee/search');
        $this->httpRequest->setIndexPath('/symfony/web/index.php');
        $result = $this->httpRequest->buildEndPoint();
        $this->assertEquals('/symfony/web/index.php/api/v1/employee/search',$result);
    }

    public function testGetTokenEndPointWithCustomIndexPath() {

        $this->httpRequest->setIndexPath('/symfony/web/index.php');
        $result = $this->httpRequest->getTokenEndPoint();
        $this->assertEquals('/symfony/web/index.php/oauth/issueToken',$result);
    }
}
