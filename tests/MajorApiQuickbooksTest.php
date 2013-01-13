<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

class MajorApiQuickbooksTest extends PHPUnit_Framework_TestCase
{

    public function testEnablingProduction()
    {
        $maq = new MajorApiQuickbooks('username', 'apikey');
        $maq->enableProduction();

        $this->assertEquals('https://majorapi.com/api/quickbooks/', $maq->getUrl());
    }

    public function testEnablingStaging()
    {
        $maq = new MajorApiQuickbooks('username', 'apikey');
        $maq->enableStaging();

        $this->assertEquals('https://staging.majorapi.com/api/quickbooks/', $maq->getUrl());
    }

    public function testEnablingDevelopment()
    {
        $maq = new MajorApiQuickbooks('username', 'apikey');
        $maq->enableDevelopment();

        $this->assertEquals('http://localhost:8000/api/quickbooks/', $maq->getUrl());
    }

    /**
     * @expectedException MajorApiException
     */
    public function testCreatingCustomerRequiresConfiguredUrl()
    {
        $maq = new MajorApiQuickbooks('username', 'apikey');
        $maq->createCustomer(['name' => 'Maynard James Keenan']);
    }

    /**
     * @expectedException MajorApiException
     */
    public function testCreatingCustomerRequiresNoErrors()
    {
        $maq = new MajorApiQuickbooks('username', 'apikey');
        $maq->enableDevelopment();

        $maq->createCustomer(['name' => 'Maynard James Keenan Ivory Waynes World Fair 2013']);
    }

}
