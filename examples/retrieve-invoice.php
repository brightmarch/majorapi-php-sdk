#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'your-majorapi-application-username';
$APPLICATION_APIKEY = 'your-majorapi-application-api-key';
$INVOICE_ID = 0; // Update to valid MajorApi Invoice ID

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableProduction();
    $quickbooksInvoice = $majorApiQuickbooks->retrieveInvoice($INVOICE_ID);

    echo(sprintf(
        "Successfully retrieved the invoice %s with ID %d.\n",
        $quickbooksInvoice->refNumber,
        $quickbooksInvoice->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
