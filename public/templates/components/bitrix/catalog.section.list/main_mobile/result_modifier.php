<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arViewModeList = ['LIST', 'LINE', 'TEXT', 'TILE'];

$arDefaultParams = [
    'VIEW_MODE' => 'LIST',
    'SHOW_PARENT_NAME' => 'Y',
    'HIDE_SECTION_NAME' => 'N'
];

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList)) {
    $arParams['VIEW_MODE'] = 'LIST';
}
if ('N' != $arParams['SHOW_PARENT_NAME']) {
    $arParams['SHOW_PARENT_NAME'] = 'Y';
}
if ('Y' != $arParams['HIDE_SECTION_NAME']) {
    $arParams['HIDE_SECTION_NAME'] = 'N';
}

$arResult['VIEW_MODE_LIST'] = $arViewModeList;


array_push($arResult['SECTIONS'], [
    'NAME' => 'Бренды',
    'SECTION_PAGE_URL' => '/manufacturers/'
]);


