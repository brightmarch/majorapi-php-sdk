#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'your-majorapi-application-username';
$APPLICATION_APIKEY = 'your-majorapi-application-api-key';
$REFERENCE_NUMBER = ''; // Update to valid QuickBooks Invoice Reference Number

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $quickbooksInvoice = $majorApiQuickbooks->retrieveInvoice($REFERENCE_NUMBER);

    echo(sprintf(
        "Successfully retrieved the invoice %s with Reference Number %s.\n",
        $quickbooksInvoice->refNumber,
        $quickbooksInvoice->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
