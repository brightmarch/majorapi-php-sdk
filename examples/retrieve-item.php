#!/usr/bin/env php
<?php

require_once __DIR__ . '/../lib/MajorApiQuickbooks.php';

$APPLICATION_USERNAME = 'brightmarch';
$APPLICATION_APIKEY = '54gktz61Z6jzOSNeup35k7gVqqFwKnRA';
$ITEM_NAME = 'BMService';

$majorApiQuickbooks = new MajorApiQuickbooks(
    $APPLICATION_USERNAME,
    $APPLICATION_APIKEY
);

try {
    $majorApiQuickbooks->enableDevelopment();
    $quickbooksItem = $majorApiQuickbooks->retrieveItem($ITEM_NAME);

    echo(sprintf(
        "Successfully retrieved the item %s with ID %d.\n",
        $quickbooksItem->name,
        $quickbooksItem->id
    ));
} catch (MajorApiException $e) {
    echo(sprintf("%s\n", $e->getMessage()));
}
