#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'your-majorapi-application-username';
$APPLICATION_APIKEY = 'your-majorapi-application-api-key';
$CUSTOMER_ID = 0; // Update to valid MajorApi Customer ID

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableProduction();
    $quickbooksCustomer = $majorApiQuickbooks->retrieveCustomer($CUSTOMER_ID);

    echo(sprintf(
        "Successfully retrieved the customer %s with ID %d.\n",
        $quickbooksCustomer->name,
        $quickbooksCustomer->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
