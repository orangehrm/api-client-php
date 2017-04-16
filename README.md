OrangeHRM API Client (PHP)
===========

A PHP client lib for the [OrangeHRM API](https://github.com/orangehrm/orangehrm-api-doc)

How to use
===========

As a start you have to install Orangehrm system and setup a oauth client 

Once you have that, You can call api as follows 

````
<?php
use Orangehrm\API\Client;
use Orangehrm\API\HTTPRequest;

$client = new Client('http://orangehrm.os','testclient','testpass');

$request = new HTTPRequest('employee/search');
$result = $this->client->get($request)->getResult;

````
