<?php
include('SEP6RESTClient.class.php');
include('SEP6RESTClientResponseObject.class.php');
include('SEP6LoggingService.class.php');

/**
 * Class SEP6Client
 *
 * PHP implementation of a Stellar SEP-6 REST client
 * see https://www.coinqvest.com/en/sep6-docs
 */
class SEP6Client extends SEP6RESTClient {

    /**
     * COINQVEST's SEP-6 transfer server
     * @var string
     */
    var $transferServer = 'sep6.coinqvest.com';
    
    /**
     * Used in the HTTP user agent (leave it as is)
     *
     * @var string
     */
    var $clientName = 'php-stellar-sep6-sdk';

    /**
     * The current version of this SDK, used in the HTTP user agent (leave it as is)
     *
     * @var string
     */
    var $clientVersion = '1.0.1';

    /**
     * Indicates whether requests and responses should be logged
     * This is automatically initialized by the constructor, see below.
     *
     * @var boolean
     */
    var $enableLogging = false;

    /**
     * Specifies the log file to which to write, if any.
     * This is initialized by the constructor, see below.
     *
     * @var string
     */
    var $logFile = null;

    /**
     * @param string $transferServer The SEP-6 transfer server
     * @param string $logFile Log file location, if any
     */
    public function __construct($transferServer = null, $logFile = null) {

        $this->transferServer = is_null($transferServer) ? $this->transferServer : $transferServer;

        if (!is_null($logFile)) {
            $this->logFile = $logFile;
            $this->enableLogging = true;
        }

        parent::__construct('https', $transferServer, '');

    }

    /**
     * Use this method to communicate with GET endpoints
     *
     * @param string $endpoint
     * @param array $params, a list of GET parameters to be included in the request
     * @return SEP6RESTClientResponseObject
     */
    public function get($endpoint = '/', $params = array()) {

        $method = 'GET';
        $response = parent::sendRequest($endpoint, $method, array(), false, $params, array(), $this->buildCustomOptions());
        $this->log("[SEP6Client][get] Request: GET $endpoint Params: " . json_encode($params));
        $this->log("[SEP6Client][get] Response: " . json_encode($response));
        return $response;

    }

    /**
     * Use this method to communicate with POST endpoints
     *
     * @param string $endpoint
     * @param array $params, an array representing the JSON payload to include in this request
     * @return SEP6RESTClientResponseObject
     */
    public function post($endpoint = '/', $params = array()) {

        $method = 'POST';
        $response = $this->sendRequest($endpoint, $method, $params, true, array(), array(), $this->buildCustomOptions());
        $this->log("[SEP6Client][post] Request: GET $endpoint Params: " . json_encode($params));
        $this->log("[SEP6Client][post] Response: " . json_encode($response));
        return $response;
    }

    /**
     * Use this method to communicate with DELETE endpoints
     *
     * @param string $endpoint
     * @param array $params, an array representing the JSON payload to include in this request
     * @return SEP6RESTClientResponseObject
     */
    public function delete($endpoint = '/', $params = array()) {

        $method = 'DELETE';
        $response = $this->sendRequest($endpoint, $method, $params, true, array(), array(), $this->buildCustomOptions());
        $this->log("[SEP6Client][delete] Request: DELETE $endpoint Params: " . json_encode($params));
        $this->log("[SEP6Client][delete] Response: " . json_encode($response));
        return $response;

    }

    /**
     * Use this method to communicate with PUT endpoints
     *
     * @param string $endpoint
     * @param array $params, an array representing the JSON payload to include in this request
     * @return SEP6RESTClientResponseObject
     */
    public function put($endpoint = '/', $params = array()) {

        $method = 'PUT';
        $response = $this->sendRequest($endpoint, $method, $params, true, array(), array(), $this->buildCustomOptions());
        $this->log("[SEP6Client][put] Request: PUT $endpoint Params: " . json_encode($params));
        $this->log("[SEP6Client][put] Response: " . json_encode($response));
        return $response;

    }

    /**
     * Private class to automatically generate the user agent in the request
     *
     * @return array
     */
    private function buildCustomOptions() {

        return array(CURLOPT_USERAGENT => $this->clientName . ' ' . $this->clientVersion);

    }

    /**
     * Private class to optionally log API request and response
     *
     * @param $message
     */
    private function log($message) {

        if (!$this->enableLogging) {
            return;
        }

        SEP6LoggingService::write($message, $this->logFile);

    }

}







