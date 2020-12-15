<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$items = $arResult['IBLOCKS'][0]['ITEMS'];
usort($items, function ($a, $b) {
    $a = mb_strtoupper(mb_substr($a['NAME'], 0, 1));
    $b = mb_strtoupper(mb_substr($b['NAME'], 0, 1));
    if ($a == $b) {
        return 0;
    }
    return $a > $b ? 1 : -1;
});

$arItemsIds = array_map(function ($item) {
    return $item['ID'];
}, $items);

foreach ($items as &$item) {
    $rsElements = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => 1,
            'PROPERTY_BREND' => $item['ID'],
            'ACTIVE' => 'Y',
        ],
        false,
        false,
        [
            'ID',
        ]
    );

    $item['ELEMENT_CNT'] = $rsElements->SelectedRowsCount();
}

$arResult['IBLOCKS'][0]['ITEMS'] = $items;
