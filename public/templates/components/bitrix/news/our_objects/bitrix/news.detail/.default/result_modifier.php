<?php
// Данные для блока "Еще объекты в..."
$db_list = CIBlockSection::GetList(Array(), [
    'ID' => $arResult['IBLOCK_SECTION_ID'],
    'IBLOCK_ID' => 15,
    'GLOBAL_ACTIVE'=>'Y',
], true);

while($ar_result = $db_list->GetNext()) {
    $arResult['CURRENT_REGION'] = [
        'ID' => $ar_result['ID'],
        'CODE' => $ar_result['CODE'],
        'NAME' => $ar_result['NAME'],
        'ITEMS' => [],
    ];

    $arSelect = [
        "ID",
        "NAME",
        "DETAIL_PAGE_URL",
        "PREVIEW_PICTURE",
        "PROPERTY_OBJECT",
        "PROPERTY_TASK"
    ];
    $arFilter = [
        "IBLOCK_ID" => 15,
        "SECTION_ID" => $ar_result['ID'],
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "!ID" => $arResult['ID'],
    ];
    $res = CIBlockElement::GetList(['sort' => 'asc'], $arFilter, false, ['nTopCount' => 4], $arSelect);
    if ($res->SelectedRowsCount()) {
        while ($ob = $res->GetNextElement()) {
            array_push($arResult['CURRENT_REGION']["ITEMS"], $ob->GetFields());
        }
    }
}

// Массив для слайдера
$arImagesIds = [
    $arResult["DETAIL_PICTURE"]['ID'],
];

if (!empty($arImagesIds)) {
    $arImages = [];
    $obFiles = CFile::GetList([], ['@ID' => implode(',', $arImagesIds)]);

    while ($arFile = $obFiles->Fetch()) {
        $arFile['SRC'] = CFile::GetFileSRC($arFile);

        $arImages[] = $arFile;
    }

    $arResult['SLIDER'] = $arImages;
}


