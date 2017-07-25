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

    public $testEmployee = null;

    protected function setUp()
    {
        $this->client = new Client('https://api-sample-cs.orangehrm.com', 'testclient', 'testpass');
        //$this->client = new Client('http://orangehrm.dev', 'testclient', 'testpass');
        $this->testEmployee = $this->addTestEmployee('John','Doe');

    }

    public function testGetToken()
    {
        $request = new HTTPRequest();
        $result = $this->client->getToken($request);
        $this->assertNotEmpty($result);
    }

    public function testGet200StatusCode()
    {
        $request = new HTTPRequest('employee/search');
        $result = $this->client->get($request);

        $this->assertArrayHasKey('data', $result->getResult());
    }

    public function testPost200StatusCode()
    {
        $request = new HTTPRequest('employee/'.$this->testEmployee['id'].'/contact-detail');
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
        $this->assertArrayHasKey('success', $result->getResult());
    }

    public function testGet202StatusCode()
    {
        $request = new HTTPRequest('leave/search?fromDate="2005-11-30"&toDate="2005-12-30"');
        $result = $this->client->get($request);

        $this->assertTrue($result->hasError());
        $this->assertEquals('toDate must be a valid date. Sample format: "2005-12-30"', $result->getError());
    }

    public function testGet404StatusCode()
    {
        $request = new HTTPRequest('employee/event?fromDate=2016-06-11&toDate=2016-05-13&type=employee&event=SAVE');
        $result = $this->client->get($request);
        $this->assertTrue($result->hasError());
        $this->assertEquals(404, $result->getStatusCode());
    }

    public function testPut200StatusCode()
    {
        $request = new HTTPRequest('employee/'.$this->testEmployee['id'].'/contact-detail');
        $request->setParams(
            [
                'addressStreet1' => '17 Clifford Road',
                'addressStreet2' => 'Johnsonville',
                'city' => 'Wellington',
                'state' => 'North',
                'zip' => '60112'
            ]
        );
        $result = $this->client->put($request);
        $this->assertArrayHasKey('success', $result->getResult());
    }

    public function testDelete200StatusCode()
    {
        $requestDependent = new HTTPRequest('employee/'.$this->testEmployee['id'].'/dependent');
        $requestDependent->setParams(
            [
                'id' => 1,
                'name' => 'Inu',
                'relationship' => 'daughter',
                'dob' => '2012-12-23'
            ]
        );
        $this->client->post($requestDependent);

        $requestDelete = new HTTPRequest('employee/'.$this->testEmployee['id'].'/dependent');
        $requestDelete->getParams(
            [
                'id' => 1
            ]
        );
        $result = $this->client->delete($requestDelete);
        $this->assertEquals(200, $result->getStatusCode());
    }

    private function addTestEmployee($firstName, $lastName) {
        $request = new HTTPRequest('employee/0');
        $request->setParams(
            [
                'firstName' => $firstName,
                'lastName' => $lastName,
            ]
        );
        $response = $this->client->post($request);
        return $response->getResult();
    }

    protected function tearDown() {
        $request = new HTTPRequest('employee/'.$this->testEmployee['id'].'/action/terminate');
        $request->setParams(
            [
                'id' => $this->testEmployee['id'],
                'date' => date("Y-m-d "),
                'reason'=> 'Terminate test employee'
            ]
        );
        $this->client->post($request);
    }
}
