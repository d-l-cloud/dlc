<?php

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define("NOT_CHECK_PERMISSIONS", true);

use Bitrix\Main;
use Bitrix\Main\Loader;

require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php');

Loader::includeModule('sale');

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/bitrix/sale.location.selector.search/class.php');

$result = true;
$errors = [];
$data = [];

try {
    CUtil::JSPostUnescape();

    $request = Main\Context::getCurrent()->getRequest()->getPostList();
    if ($request['version'] == '2') {
        $data = CBitrixLocationSelectorSearchComponent::processSearchRequestV2($_REQUEST);
    } else {
        $data = CBitrixLocationSelectorSearchComponent::processSearchRequest();
    }
} catch (Main\SystemException $e) {
    $result = false;
    $errors[] = $e->getMessage();
}

echo json_encode([
    'result' => $result,
    'errors' => $errors,
    'data' => $data
], true);