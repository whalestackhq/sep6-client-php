<?php
/**
 * Class SEP6RESTClient
 */
class SEP6RESTClient {

    protected $scheme;
    protected $host;
    protected $path;
    protected $port;
    protected $basicAuthUsername;
    protected $basicAuthPassword;

    public function __construct($scheme = 'https', $host = 'www.example.com', $path = '/api', $port = null, $basicAuthUsername = null, $basicAuthPassword = null) {
        foreach (get_defined_vars() as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Sends an arbitrary HTTP GET, POST, PUT or DELETE request
     *
     * @param $endpoint
     * @param $requestType
     * @param array $requestBody
     * @param bool|false $sendAsJson
     * @param array $query
     * @param array $headers
     * @param array $customOptions
     * @return SEP6RESTClientResponseObject
     */
    protected function sendRequest($endpoint, $requestType, $requestBody = array(), $sendAsJson = false, $query = array(), $headers = array(), $customOptions = array()) {

        $ch = curl_init($this->scheme . '://' . $this->host . $this->path . $endpoint . (!empty($query) ? '?' . http_build_query($query) : null));
        curl_setopt($ch, CURLOPT_PORT, $this->port ? $this->port : ($this->scheme == 'https' ? 443 : 80));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Whalestack SEP-6 REST Client (Base)');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (!is_null($this->basicAuthUsername) && !is_null($this->basicAuthPassword)) {
            curl_setopt($ch, CURLOPT_USERPWD, $this->basicAuthUsername . ":" . $this->basicAuthPassword);
        }

        $headers[] = 'Expect:'; // prevent "HTTP/1.1 100 Continue"
        $headers[] = 'Content-Type: application/json; charset=UTF-8'; // set content-type
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        switch ($requestType) {
            case('POST'):
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $sendAsJson ? json_encode($requestBody) : $requestBody);
                break;
            case('GET'):
                break;
            case('DELETE'):
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $sendAsJson ? json_encode($requestBody) : $requestBody);
                break;
            case('PUT'):
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $sendAsJson ? json_encode($requestBody) : $requestBody);
                break;
            default:
                // invalid request type
                exit;
                break;
        }

        foreach ($customOptions as $key => $value) {
            curl_setopt($ch, $key, $value);
        }

        $response = trim(curl_exec($ch));
        $separator = "\r\n\r\n";
        $responseHeaders = null;
        $responseBody = null;
        if (strpos($response, $separator)) {
            list($responseHeaders, $responseBody) = explode($separator, $response, 2);
        }

        $restClientResponseObject = new SEP6RESTClientResponseObject(
            $responseBody,
            $responseHeaders,
            curl_getinfo($ch, CURLINFO_HTTP_CODE),
            curl_error($ch),
            curl_errno($ch),
            curl_getinfo($ch)
        );

        curl_close($ch);

        return $restClientResponseObject;

    }

}