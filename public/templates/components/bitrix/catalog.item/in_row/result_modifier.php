<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (empty($arResult["ITEM"]['PREVIEW_PICTURE']["ID"]) && !empty($arResult["ITEM"]["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
    $arResult["ITEM"]['PREVIEW_PICTURE'] = CFile::GetFileArray($arResult["ITEM"]["PROPERTIES"]["MORE_PHOTO"]["VALUE"][0]);
}

if ((int)$arResult['ITEM']['OFFER_ID_SELECTED'] > 0 && count($arResult['ITEM']['OFFERS']) > 0) {
    $offersIblockId = $arResult['ITEM']['OFFERS'][0]['IBLOCK_ID'];

    $property = \CIBlockElement::GetProperty(
        $offersIblockId,
        $arResult['ITEM']['OFFER_ID_SELECTED'],
        'sort',
        'asc',
        [
            'CODE' => 'CML2_ARTICLE'
        ]
    )->Fetch();

    if ($property && !empty($property['VALUE'])) {
        $arResult['ITEM']['DETAIL_PAGE_URL'] .= '?article=' . $property['VALUE'];
    }
}

if (!empty($arResult['ITEM']['PREVIEW_PICTURE']['ID'])) {
    $file_headers = @get_headers($arResult['ITEM']['PREVIEW_PICTURE']['SRC']);

    if($file_headers[0] == 'HTTP/1.0 200 OK') {
        $file = CFile::ResizeImageGet(
            $arResult['ITEM']['PREVIEW_PICTURE']['ID'],
            [
                'width' => 290,
                'height' => 290,
            ],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            false
        );

        $arResult['ITEM']['RESIZED_PREVIEW_PICTURE_LIST_SRC'] = $file['src'];

        $file = CFile::ResizeImageGet(
            $arResult['ITEM']['PREVIEW_PICTURE']['ID'],
            [
                'width' => 400,
                'height' => 250,
            ],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            false
        );

        $arResult['ITEM']['RESIZED_PREVIEW_PICTURE_BASKET_SRC'] = $file['src'];
    }
}


switch ($arParams['BLOCK']) {
    case 'SLIDER':
        $arResult['BLOCK_CLASS'] = 'item-in-slider';
        break;
    case 'CATALOG':
    default:
        $arResult['BLOCK_CLASS'] = 'item-in-catalog';
}