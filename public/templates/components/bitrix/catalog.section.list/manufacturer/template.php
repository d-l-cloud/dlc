<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['SECTIONS'] as $section) {
    $APPLICATION->IncludeComponent(
        'bitrix:catalog.section',
        'manufacturer',
        [
            'IBLOCK_TYPE'          => 'cat',
            'IBLOCK_ID'            => 1,
            'SECTION_ID'           => $section['ID'],
            'FILTER_NAME'          => 'arrFilter',
            'INCLUDE_SUBSECTIONS'  => 'Y',
            'CACHE_TYPE'           => 'A',
            'CACHE_TIME'           => 36000000,
            'CACHE_GROUPS'         => 'Y',
            'SET_TITLE'            => 'N',
            'SET_BROWSER_TITLE'    => 'N',
            'SET_META_KEYWORDS'    => 'N',
            'SET_META_DESCRIPTION' => 'N',
            'BREND'                => $arParams['BREND'],
            'BRAND_LINK_FILTER'    => $arParams['BRAND_LINK_FILTER'],
            "PRICE_CODE" => getUserPriceGroup($USER),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "CONVERT_CURRENCY" => "Y",
            "CURRENCY_ID" => "RUB",
        ]
    );
}