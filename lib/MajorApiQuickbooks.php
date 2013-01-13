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

    private $successCodes = [200, 201, 202];

    public function __construct($applicationUsername, $applicationApiKey)
    {
        $this->applicationUsername = strtolower($applicationUsername);
        $this->applicationApiKey = $applicationApiKey;

        $this->_configureUrls();
    }

    public function createCustomer(array $customer)
    {
        return $this->_sendRequest('POST', 'customers', $customer);
    }

    public function createInvoice(array $invoice)
    {
        return $this->_sendRequest('POST', 'invoices', $invoice);
    }

    public function retrieveInvoice($invoiceId)
    {
        $resource = sprintf('invoices/%d', (int)$invoiceId);

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

    public function enableProduction()
    {
        $this->url = $this->urls['production'];

        return $this;
    }

    public function enableStaging()
    {
        $this->url = $this->urls['staging'];

        return $this;
    }

    public function enableDevelopment()
    {
        $this->url = $this->urls['development'];

        return $this;
    }

    public function getUrl()
    {
        if (empty($this->url)) {
            throw new MajorApiException(
                "No URL is configured. Please call one of " .
                "enableProduction(), enableStaging(), or " .
                "enableDevelopment() to configure the proper URL."
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
        $response = json_decode(curl_exec($curl));
        $responseCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!in_array($responseCode, $this->successCodes)) {
            throw new MajorApiException(sprintf(
                "An error occurred when attempting to contact " .
                "the MajorApi: QuickBooks REST API. The error states: %s",
                $response->message
            ));
        }

        return $response;
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

}
