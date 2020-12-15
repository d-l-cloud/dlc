<?php

if (count($arResult["ITEMS"])) {
    global $arAllSections;
    $arResult['SECTIONS'] = [];

    foreach ($arResult["ITEMS"] as $arItem) {
        $arSection = $arAllSections[$arItem['IBLOCK_SECTION_ID']];
        if (!empty($arSection)) {
            if (!empty($arResult['SECTIONS'][$arSection['ID']])) {
                $arResult['SECTIONS'][$arSection['ID']]['ITEMS'][] = $arItem;
            } else {
                $arSection['ITEMS'][] = $arItem;
                $arResult['SECTIONS'][$arSection['ID']] = $arSection;
            }
        }
    }
}