<?php

require_once __DIR__ . '/MajorApiException.php';

class MajorApiQuickbooks
{

    /** @var string */
    private $applicationUsername = '';

    /** @var string */
    private $aplicationApiKey = '';

    /** @var array */
    private $urls = [];

    /** @var string */
    private $url = '';

    /* @var array */
    private $successCodes = [200, 201, 202];

    /** @const integer */
    const PRODUCTION_API_KEY_LENGTH = 32;

    /** @const integer */
    const STAGING_API_KEY_LENGTH = 24;

    /** @const integer */
    const DEVELOPMENT_API_KEY_LENGTH = 16;

    public function __construct($applicationUsername, $applicationApiKey)
    {
        $this->applicationUsername = strtolower($applicationUsername);
        $this->applicationApiKey = trim($applicationApiKey);

        $this->_configureUrls()
            ->_determineUrl();
    }

    public function createCustomer(array $customer)
    {
        return $this->_sendRequest('POST', 'customers', $customer);
    }

    public function createInvoice(array $order)
    {
        $order['type'] = 'invoice';

        return $this->_sendRequest('POST', 'orders', $order);
    }

    public function createSalesOrder(array $order)
    {
        $order['type'] = 'sales-order';

        return $this->_sendRequest('POST', 'orders', $order);
    }

    public function retrieveInvoice($refNumber)
    {
        $resource = sprintf('orders/%s', $refNumber);

        return $this->_sendRequest('GET', $resource);
    }

    public function retrieveSalesOrder($refNumber)
    {
        $resource = sprintf('orders/%s', $refNumber);

        return $this->_sendRequest('GET', $resource);
    }

    public function retrieveCustomer($customerId)
    {
        $resource = sprintf('customers/%d', (int)$customerId);

        return $this->_sendRequest('GET', $resource);
    }

    public function retrieveItem($itemName)
    {
        $resource = sprintf('items/%s', $itemName);

        return $this->_sendRequest('GET', $resource);
    }

    public function getUrl()
    {
        if (empty($this->url)) {
            throw new MajorApiException(
                "No URL is configured. Please use a valid API Key."
            );
        }

        return $this->url;
    }



    private function _sendRequest($method, $resource, array $entity=[])
    {
        $url = sprintf(
            '%s%s',
            $this->getUrl(),
            $resource
        );

        $authorization = sprintf(
            '%s:%s',
            $this->applicationUsername,
            $this->applicationApiKey
        );

        $options = [
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => ['Accept: application/json', 'Expect:'],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_URL => $url,
            CURLOPT_USERPWD => $authorization
        ];

        if (is_array($entity) && count($entity) > 0) {
            $options[CURLOPT_POSTFIELDS] = http_build_query($entity);
        }

        $curl = curl_init();
            curl_setopt_array($curl, $options);
            $responseJson = curl_exec($curl);
            $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $responseJsonDecoded = json_decode($responseJson);

        if (!in_array($responseCode, $this->successCodes)) {
            throw new MajorApiException(sprintf(
                "An error occurred when attempting to contact " .
                "the MajorApi: QuickBooks REST API. The error states: %s",
                $responseJsonDecoded->message
            ));
        }

        return $responseJsonDecoded;
    }

    private function _configureUrls()
    {
        $this->urls = [
            'production' => 'https://majorapi.com/api/quickbooks/',
            'staging' => 'https://staging.majorapi.com/api/quickbooks/',
            'development' => 'http://localhost:8000/api/quickbooks/'
        ];

        return $this;
    }

    private function _determineUrl()
    {
        $apiKeyLength = strlen($this->applicationApiKey);

        if ($apiKeyLength == self::PRODUCTION_API_KEY_LENGTH) {
            $this->url = $this->urls['production'];
        } elseif ($apiKeyLength == self::STAGING_API_KEY_LENGTH) {
            $this->url = $this->urls['staging'];
        } elseif ($apiKeyLength == self::DEVELOPMENT_API_KEY_LENGTH) {
            $this->url = $this->urls['development'];
        }

        return $this;
    }

}
