#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'your-majorapi-application-username';
$APPLICATION_APIKEY = 'your-majorapi-application-api-key';

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $quickbooksCustomer = $majorApiQuickbooks->createCustomer([
        'name' => 'Maynard James Keenan',
        'firstName' => 'Maynard',
        'middleName' => 'J',
        'lastName' => 'Keenan',
        'companyName' => 'Tool Band, Inc.',
        'position' => 'Lead Singer',
        'billAddress1' => '1000 Summerset Drive',
        'billCity' => 'Los Angeles',
        'billState' => 'CA',
        'billPostalCode' => '90210',
        'billCountry' => 'US'
    ]);

    echo(sprintf(
        "Successfully created the customer %s with ID %d.\n",
        $quickbooksCustomer->name,
        $quickbooksCustomer->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
