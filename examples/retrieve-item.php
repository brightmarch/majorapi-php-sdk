#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = '';
$APPLICATION_APIKEY = '';
$ITEM_NAME = '';

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableProduction();
    $quickbooksItem = $majorApiQuickbooks->retrieveItem($ITEM_NAME);

    echo(sprintf(
        "Successfully retrieved the item %s with ID %d.\n",
        $quickbooksItem->name,
        $quickbooksItem->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
