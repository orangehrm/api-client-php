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

use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * @var Domain string
     */
    private $domain = '';

    /**
     * @var Client Id int
     */
    private $clientId = 0;

    /**
     * @var Client Secret string
     */
    private $clientSecret = '';

    /**
     * @var Grant Type string
     */
    private $grantType = 'client_credentials';

    /**
     * @var version number string
     */
    private $version = 'v1';

    /**
     * @var null
     */
    private $httpClient = null;

    /**
     * Client constructor.
     * @param $domain
     * @param $clientId
     * @param $clientSecret
     */
    public function __construct($domain, $clientId, $clientSecret)
    {

        $this->setDomain($domain)
            ->setClientId($clientId)
            ->setClientSecret($clientSecret);

        $this->setHttpClient(new HttpClient(['base_uri' => $domain, 'Content-Type' => 'application/json' ]));
    }

    /**
     * @return Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     * @return $this;
     */
    private function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param Client $clientId
     * @return $this;
     */
    private function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param Client $clientSecret
     * @return $this;
     */
    private function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @return Grant
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * @param Grant $grantType
     * @return $this;
     */
    private function setGrantType($grantType)
    {
        $this->grantType = $grantType;
        return $this;
    }

    /**
     * @return version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param version $version
     * @return $this;
     */
    private function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return null
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param null $httpClient
     * @return $this;
     */
    private function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }


    public function getToken() {
        $response = $this->getHttpClient()
            ->post(
                '/symfony/web/index.php/oauth/issueToken',
                ['form_params'=>
                    [
                        'client_id' => $this->getClientId(),
                        'client_secret'=>$this->getClientSecret(),
                        'grant_type'=>$this->getGrantType()
                    ]
                ]

            );
       $result= json_decode($response->getBody()->getContents(),true);
       return $result['access_token'];
    }

    public function get($endPoint, $params = array()) {
        $token  = $this->getToken();
        $data = ['headers' => [
            'Authorization' => 'Bearer ' . $token,
        ]];
        $response = $this->getHttpClient()
            ->get($endPoint,$data);
        return json_decode($response->getBody()->getContents(),true);
    }
}
