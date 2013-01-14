<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

class MajorApiQuickbooksTest extends PHPUnit_Framework_TestCase
{

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

        $maq->createCustomer(['name' => 'Maynard James Keenan Ivory Waynes World Fair 2013']);
    }

}
