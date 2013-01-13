#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'brightmarch';
$APPLICATION_APIKEY = '54gktz61Z6jzOSNeup35k7gVqqFwKnRA';
$INVOICE_ID = 8;

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableDevelopment();
    $quickbooksInvoice = $majorApiQuickbooks->retrieveInvoice($INVOICE_ID);

    echo(sprintf(
        "Successfully retrieved the invoice %s with ID %d.\n",
        $quickbooksInvoice->refNumber,
        $quickbooksInvoice->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
