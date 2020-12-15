<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arResult['NAV_NUM'] = $arResult['NAV_RESULT']->NavNum; 
$arResult['NAV_PAGE_NOMER'] = $arResult['NAV_RESULT']->NavPageNomer; 
$arResult['NAV_PAGE_COUNT'] = $arResult['NAV_RESULT']->NavPageCount; 
$arResult['SECTION_CODE'] = $arParams["SECTION_CODE"];
$this->__component->SetResultCacheKeys([
    'NAV_NUM',
    'NAV_PAGE_NOMER',
    'NAV_PAGE_COUNT',
    'SECTION_CODE',
]);

if(isset($_REQUEST['q'])){
    foreach($arResult['ITEMS'] as &$item){
        foreach($item['OFFERS'] as $k => $offer){
            if($offer['PROPERTIES']['CML2_ARTICLE']['VALUE'] == $_REQUEST['q']){
                $firstOffer = $item['OFFERS'][0];
                $item['OFFERS'][0] = $offer;
                $item['OFFERS'][$k] = $firstOffer;
                $arResult['ARTICLE_SEARCH'] = true;
                break;
            }
        }
    }
    unset($item);
}

// устанавливаем порядок результатов поиска
if($arParams['ELEMENT_SORT_FIELD'] == 'rank') {
    global ${$arParams['FILTER_NAME']};
    $rankedIds = ${$arParams['FILTER_NAME']}[0][0]['=ID'];
    if(is_array($rankedIds)) {
        $rankedItems = array();
        $unranked = array();
        foreach ($arResult['ITEMS'] as $key => $item) {
            $i = 0;
            foreach ($rankedIds as $id) {
                if ($item['ID'] == $id) {
                    $rankedItems[$i] = $item;
                    break;
                }
                $i++;
            }
            if (!$rankedItems[$i]) {
                $unranked[] = $item;
            }
        }
        ksort($rankedItems);
        $arResult['ITEMS'] = array_merge($rankedItems, $unranked);
        unset($rankedItems);
        unset($unranked);
    }
}

$searchedOffers = array_filter(
    $arResult['ITEMS'],
    function($item){
        return $item['IBLOCK_ID'] === 2;
    }
);

$searchedOffersId = array_column($searchedOffers, 'ID');
$offersToDelete = [];

foreach ($arResult['ITEMS'] as $key => $item) {
    #echo $item['ID'] . ' ' . $item['NAME'] . ' ' . $item['IBLOCK_ID'] . '<br/>';


    if(count($item['OFFERS'])){
        $itemOfferIds = array_column($item['OFFERS'], 'ID');

        $foundItemsOffersCount = count(array_intersect($itemOfferIds, $searchedOffersId));

        //если нашли все предложения товара, выводим сам товар, иначе найденные предложения
        if($foundItemsOffersCount >= count($itemOfferIds)){
            $offersToDelete = array_merge($offersToDelete, $itemOfferIds);
        } elseif ($foundItemsOffersCount > 0) {

            foreach ($arResult['ITEMS'][$key]['OFFERS'] as $offer){
                foreach ($arResult['ITEMS'] as $keySearch => $itemSearch) {
                    if($itemSearch['ID'] == $offer['ID'] && $itemSearch['IBLOCK_ID'] === 2){
                        $arResult['ITEMS'][$keySearch]['CATALOG_QUANTITY'] = $offer['CATALOG_QUANTITY'];
                        $arResult['ITEMS'][$keySearch]['MIN_QUANTITY'] = $offer['MIN_QUANTITY'];
                        $arResult['ITEMS'][$keySearch]['ITEM_PRICE_SELECTED'] = $offer['ITEM_PRICE_SELECTED'];
                        $arResult['ITEMS'][$keySearch]['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']] = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                        break;
                    }
                }
            }

            unset($arResult['ITEMS'][$key]);
            continue;
        }
    }
}

if(count($offersToDelete)){
    foreach ($arResult['ITEMS'] as $key => $item) {
        if(in_array($item['ID'], $offersToDelete)){
            unset($arResult['ITEMS'][$key]);
        }
    }
}

foreach ($arResult['ITEMS'] as $i => $item) {
    if ($item['IBLOCK_ID'] == 2) {
        $obCache = new CPHPCache();
        if($obCache->InitCache(
            3600,
            'offer_article_photo_'.json_encode([$item['IBLOCK_ID'], $item['ID'], $item['PREVIEW_PICTURE']['SRC']]),
            '/catalog/offers/')
        ){
            $vars = $obCache->GetVars();
            $propertyArticle = $vars[0];
            $propertyPhotoSrc = $vars[1];
        }elseif($obCache->StartDataCache()){
            $propertyArticle = \CIBlockElement::GetProperty($item['IBLOCK_ID'], $item['ID'], 'sort', 'asc', ['CODE' => 'CML2_ARTICLE'])->Fetch();
            if ($propertyArticle && !empty($propertyArticle['VALUE'])) {
                $propertyArticle = $propertyArticle['VALUE'];
            }

            $propertyPhotoSrc = false;
            if(strpos($item['PREVIEW_PICTURE']['SRC'], 'no_photo') !== false) {
                $propertyPhoto = \CIBlockElement::GetProperty($item['IBLOCK_ID'], $item['ID'], 'sort', 'asc', ['CODE' => 'MORE_PHOTO'])->Fetch();
                if($propertyPhoto['VALUE'] > 0){
                    $propertyPhotoSrc = CFile::GetPath($propertyPhoto['VALUE']);
                }
            }
            $obCache->EndDataCache(array($propertyArticle, $propertyPhotoSrc));
        }

        if ($propertyArticle && $arResult['ITEMS'][$i]['DETAIL_PAGE_URL'] !== '/katalog/') {
            $arResult['ITEMS'][$i]['DETAIL_PAGE_URL'] .= '?article=' . $propertyArticle;
            $arResult['ITEMS'][$i]['PROPERTIES']['CML2_ARTICLE']['VALUE'] = $propertyArticle;
        } else {
            // удаляем торговые предложения, не привязанные к товарам
            unset($arResult['ITEMS'][$i]);
        }

        if($propertyPhotoSrc){
            $arResult['ITEMS'][$i]['PREVIEW_PICTURE']['SRC'] = $propertyPhotoSrc;
        }
    }
}