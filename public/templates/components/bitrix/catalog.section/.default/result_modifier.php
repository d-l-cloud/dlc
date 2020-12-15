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

foreach ($arResult['ITEMS'] as $i => $item) {
    if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER']))
    {
        if (strlen($this->__component->getCachePath()))
        {
            $GLOBALS['CACHE_MANAGER']->RegisterTag('catalog_product_' . $item['ID']);
        }
    }

    if ($item['IBLOCK_ID'] == 2) {
        $property = \CIBlockElement::GetProperty($item['IBLOCK_ID'], $item['ID'], 'sort', 'asc', ['CODE' => 'CML2_ARTICLE'])->Fetch();
        if ($property && !empty($property['VALUE'])) {
            $arResult['ITEMS'][$i]['DETAIL_PAGE_URL'] .= '?article=' . $property['VALUE'];
        }
    }
}