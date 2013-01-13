#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'brightmarch';
$APPLICATION_APIKEY = '54gktz61Z6jzOSNeup35k7gVqqFwKnRA';
$CUSTOMER_ID = 11;

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableDevelopment();
    $quickbooksCustomer = $majorApiQuickbooks->retrieveCustomer($CUSTOMER_ID);

    echo(sprintf(
        "Successfully retrieved the customer %s with ID %d.\n",
        $quickbooksCustomer->name,
        $quickbooksCustomer->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
