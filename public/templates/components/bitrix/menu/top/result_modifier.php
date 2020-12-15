<?php

$arNewResult = [];
$iLastParent = -1;
foreach ($arResult as $arItem) {
    if (substr($arItem["TEXT"], 0, 3) == '[D]') {
        $arItem['IS_DELIVERY'] = true;
        $arItem['TEXT'] = substr($arItem["TEXT"], 3);
    } else {
        $arItem['IS_DELIVERY'] = false;
    }

    if ($arItem['IS_PARENT'] || $arItem['DEPTH_LEVEL'] == 1) {
        $iLastParent++;
        $arNewResult[] = $arItem;
    } else {
        $arNewResult[$iLastParent]['CHILDRENS'][] = $arItem;
    }
}

$arResult = $arNewResult;