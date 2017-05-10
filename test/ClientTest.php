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

use Orangehrm\API\Client;
use Orangehrm\API\HTTPRequest;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public $client = null;

    protected function setUp()
    {
        $this->client = new Client('https://api-sample-cs.orangehrm.com','testclient','testpass');
    }

    public function testGetToken(){
        $request = new HTTPRequest();
        $result = $this->client->getToken($request);
        $this->assertNotEmpty($result);
    }

    public function testGetRequest() {
        $request = new HTTPRequest('employee/search');
        $result = $this->client->get($request);

        $this->assertArrayHasKey('data',$result->getResult());
    }

    public function testPostRequest() {
        $request = new HTTPRequest('employee/1/contact-detail');
        $request->setParams(
            [
                'addressStreet1' => '17 Clifford Road',
                'addressStreet2' => 'Johnsonville',
                'city' => 'Wellington',
                'state' => 'North',
                'zip' => '60113'
            ]
        );
        $result = $this->client->post($request);
        $this->assertArrayHasKey('success',$result->getResult());
    }

    public function testErrorResult() {
        $request = new HTTPRequest('leave/search?fromDate="2005-11-30"&toDate="2005-12-30"');
        $result = $this->client->get($request);
        $this->assertTrue($result->hasError());
        $this->assertEquals('toDate must be a valid date. Sample format: "2005-12-30"',$result->getError());
        $this->assertEquals(202,$result->getStatusCode());
    }
}
