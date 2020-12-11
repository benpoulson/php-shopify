<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 8/24/16 9:03 AM UTC+06:00
 */

namespace PHPShopify;

/**
 * Class HttpRequestJson
 *
 * Prepare the data / headers for JSON requests, make the call and decode the response
 * Accepts data in array format returns data in array format
 *
 * @uses CurlRequest
 *
 * @package PHPShopify
 */
class HttpRequestJson
{

    /**
     * HTTP request headers
     *
     * @var array
     */
    protected $httpHeaders;

    /**
     * Prepared JSON string to be posted with request
     *
     * @var string
     */
    private $postDataJSON;


    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $httpHeaders
     * @param array $dataArray
     *
     * @return void
     */
    protected function prepareRequest($httpHeaders = array(), $dataArray = array())
    {

        $this->postDataJSON = json_encode($dataArray);

        $this->httpHeaders = $httpHeaders;

        if (!empty($dataArray)) {
            $this->httpHeaders['Content-type'] = 'application/json';
            $this->httpHeaders['Content-Length'] = strlen($this->postDataJSON);
        }
    }

    /**
     * Implement a GET request and return json decoded output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return array
     */
    public function get($url, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders);

        $response = CurlRequest::get($url, $this->httpHeaders);

        return self::processResponse($response);
    }

    /**
     * Implement a POST request and return json decoded output
     *
     * @param string $url
     * @param array $dataArray
     * @param array $httpHeaders
     *
     * @return array
     */
    public function post($url, $dataArray, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders, $dataArray);

        $response = CurlRequest::post($url, $this->postDataJSON, $this->httpHeaders);

        return self::processResponse($response);
    }

    /**
     * Implement a PUT request and return json decoded output
     *
     * @param string $url
     * @param array $dataArray
     * @param array $httpHeaders
     *
     * @return array
     */
    public function put($url, $dataArray, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders, $dataArray);

        $response = CurlRequest::put($url, $this->postDataJSON, $this->httpHeaders);

        return self::processResponse($response);
    }

    /**
     * Implement a DELETE request and return json decoded output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return array
     */
    public function delete($url, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders);

        $response = CurlRequest::delete($url, $this->httpHeaders);

        return self::processResponse($response);
    }

    /**
     * Decode JSON response
     *
     * @param string $response
     *
     * @return array
     */
    protected function processResponse($response)
    {

        return json_decode($response, true);
    }

}
