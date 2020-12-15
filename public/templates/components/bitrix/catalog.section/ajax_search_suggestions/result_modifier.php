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

$arResult['ITEMS'] = array_slice($arResult['ITEMS'], 0, $arParams['PAGE_ELEMENT_SHOW']);

foreach ($arResult['ITEMS'] as $key => $item) {
    if (!empty($item['PREVIEW_PICTURE']['ID'])) {
        $file = CFile::ResizeImageGet(
            $item['PREVIEW_PICTURE']['ID'],
            array(
                'width' => 50,
                'height' => 50
            ),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            false
        );

        $arResult['ITEMS'][$key]['RESIZED_PREVIEW_PICTURE_SRC'] = $file['src'];
    }
}