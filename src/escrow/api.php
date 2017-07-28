<?php namespace Escrow;

/**
 * Escrow.com Api Wrapper
 * - This package is a very lightweight api wrapper for Escrow and PHP 5+.
 * - cURL is not required for usage of this package.
 * - Enjoy!
 *
 * @package deboorn/Escrow-api
 * @copyright Daniel Boorn <daniel.boorn@gmail.com>
 * @license MIT license
 */

/**
 * Class Exception
 * @package Escrow
 */
class Exception extends \Exception
{

}


/**
 * Class Api
 *
 * Escrow.com Api Wrapper
 * See readme.md for examples of use
 *
 * @package Escrow
 */
class Api
{
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    protected $username, $password, $apiUri;

    /**
     * @param string $username
     * @param string $password
     * @param string $apiUri
     */
    public function __construct($username, $password, $apiUri = 'https://stgsecureapi.escrow.com/api')
    {
        $this->username = $username;
        $this->password = $password;
        $this->apiUri = $apiUri;
    }

    /**
     * Create Transaction
     *
     * @param array $params
     * @return mixed
     */
    public function createTransaction(array $params)
    {
        return $this->post('/Transaction', $params);
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function post($endpoint, array $params = array())
    {
        $params = json_encode($params);
        return $this->fetch($endpoint, $params, 'POST');
    }

    /**
     * Fetch api endpoint response
     *
     * @param $endpoint
     * @param string $data
     * @param string $verb
     * @return mixed
     * @throws Exception
     */
    public function fetch($endpoint, $data = "", $verb = 'GET')
    {

        $queryStr = "";
        if (is_array($data) && $verb == 'GET') {
            $queryStr = http_build_query($data);
            $data = "";
        }

        $context = stream_context_create(array(
            'http' => array(
                'method'  => $verb,
                'header'  => $this->getAuthHeader() . "\r\nContent-Type: application/json\r\nAccept: application/jso\r\n",
                'content' => $data,
            ),
            'ssl'  => array(
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ),
        ));

        $url = rtrim("{$this->apiUri}{$endpoint}?{$queryStr}", '?');

        $buffer = file_get_contents($url, false, $context);
        $response = json_decode($buffer, true);


        if (empty($response)) {
            throw new Exception('Invalid Response from Escrow API', 500);
        }

        return $response;
    }

    /**
     * Returns basic authorization header
     *
     * @return string
     */
    protected function getAuthHeader()
    {
        return sprintf('Authorization: Basic %s', base64_encode("$this->username:$this->password"));
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getStatus(array $params)
    {
        return $this->get('/Status', $params);
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function get($endpoint, array $params = array())
    {
        return $this->fetch($endpoint, $params);
    }

    /**
     * Add Shipment Tracking Information
     *
     * @param array $params
     * @return mixed
     */
    public function updateShipping(array $params)
    {
        return $this->post('/Shipping', $params);
    }

    /**
     * Add Settlement Information
     *
     * @param array $params
     * @return mixed
     */
    public function updateSettlement(array $params)
    {
        return $this->post('/Settlement', $params);
    }


}

