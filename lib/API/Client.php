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
use GuzzleHttp\Exception\RequestException;

class Client
{
    /**
     * @var Domain string
     */
    private $domain = '';

    /**
     * @var string
     */
    private $path = '';

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
     * @var string
     */
    private $indexPath = '/index.php';

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
        $url = parse_url($domain);
        $baseUrl = $url['scheme'] . '://' . $url['host'];

        $this->setDomain($baseUrl)
            ->setClientId($clientId)
            ->setClientSecret($clientSecret);

        if (isset($url['path'])) {
            $this->setPath($url['path']);
        }

        $this->setHttpClient(new HttpClient(['base_uri' => $baseUrl, 'Content-Type' => 'application/json']));
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

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this;
     */
    private function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndexPath()
    {
        return $this->indexPath;
    }

    /**
     * @param string $indexPath
     * @return $this;
     */
    public function setIndexPath($indexPath)
    {
        $this->indexPath = $indexPath;
        return $this;
    }

    /**
     * @param HTTPRequest $request
     * @return HTTPResponse $response
     */
    public function getToken(HTTPRequest $request)
    {
        $request->setBasePath($this->getPath());
        $result = $this->getHttpClient()
            ->post(
                $request->getTokenEndPoint(),
                [
                    'form_params' =>
                        [
                            'client_id' => $this->getClientId(),
                            'client_secret' => $this->getClientSecret(),
                            'grant_type' => $this->getGrantType()
                        ]
                ]

            );
        return new HTTPResponse($result);
    }

    /**
     * @param HTTPRequest $request
     * @return HTTPResponse
     */
    public function get(HTTPRequest $request)
    {
        try {
            $tokenResponse = $this->getToken($request);
            $request->setBasePath($this->getPath());
            $data = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokenResponse->getToken(),
                ]
            ];
            $response = $this->getHttpClient()
                ->get($request->buildEndPoint(), $data);

            $httpResponse = new HTTPResponse($response);
            return $httpResponse;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $httpResponse = new HTTPResponse($e);
                $httpResponse->setStatusCode($e->getCode());
                return $httpResponse;
            } else{
                throw $e;
            }

        }

    }
}
