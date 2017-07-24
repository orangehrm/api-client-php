<?php
/**
 * Created by PhpStorm.
 * User: samantha
 * Date: 24/07/17
 * Time: 4:35 PM
 */

namespace Orangehrm\API;

interface IClient {

    /**
     * @param HTTPRequest $request
     *
     * @return HTTPResponse
     */
    public function get(HTTPRequest $request);

    /**
     * @param HTTPRequest $request
     *
     * @return HTTPResponse
     */
    public function post(HTTPRequest $request);

    /**
     * @param HTTPRequest $request
     *
     * @return HTTPResponse
     */
    public function put(HTTPRequest $request);

    /**
     * @param HTTPRequest $request
     *
     * @return HTTPResponse
     */
    public function delete(HTTPRequest $request);
}
