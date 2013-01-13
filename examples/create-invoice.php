#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'brightmarch';
$APPLICATION_APIKEY = '54gktz61Z6jzOSNeup35k7gVqqFwKnRA';
$CUSTOMER_NAME = 'Maynard James Keenan';
$ITEM_NAME = 'BMService';

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableDevelopment();
    $quickbooksInvoice = $majorApiQuickbooks->createInvoice([
        'refNumber' => mt_rand(1, 1000000),
        'customerName' => $CUSTOMER_NAME,
        'invoiceLine' => [
            [
                'itemName' => $ITEM_NAME,
                'quantityOrdered' => mt_rand(1, 10)
            ]
        ]
    ]);

    echo(sprintf(
        "Successfully created the invoice %s with ID %d.\n",
        $quickbooksInvoice->refNumber,
        $quickbooksInvoice->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
