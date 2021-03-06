#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'your-majorapi-application-username';
$APPLICATION_APIKEY = 'your-majorapi-application-api-key';
$CUSTOMER_NAME = 'a-valid-customer-name';
$ITEM_NAME = 'a-valid-item-name';

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $quickbooksInvoice = $majorApiQuickbooks->createInvoice([
        'refNumber' => time(),
        'customerName' => $CUSTOMER_NAME,
        'invoiceLines' => [
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
