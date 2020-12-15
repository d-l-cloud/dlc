<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();

if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER']))
{
    if (strlen($this->__component->getCachePath()))
    {
        $GLOBALS['CACHE_MANAGER']->RegisterTag('catalog_product_' . $arResult['ID']);
    }
}

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
    $arResult['VIEWED_PRODUCT']['OFFER_ID'];
    $offerKey = array_search($arResult['VIEWED_PRODUCT']['OFFER_ID'], array_column($arResult['OFFERS'], 'ID'));
    $arResult['ITEM_PRICE'] = $arResult['OFFERS'][$offerKey]['MIN_PRICE']['DISCOUNT_VALUE'];
} else {
    $arResult['ITEM_PRICE'] = $arResult['MIN_PRICE']['DISCOUNT_VALUE'];
}

$res = CIBlockElement::GetElementGroups($arResult['ID']);
while ($ob = $res->Fetch()) {
    $sections[] = $ob["ID"];
}

if (count($sections) > 0) {
    $deepestSection = CIBlockSection::GetList(['DEPTH_LEVEL' => 'DESC'], ['ID' => $sections])->GetNext();

    if (strpos($_SERVER['REQUEST_URI'], $deepestSection['SECTION_PAGE_URL']) !== 0) {
        $arResult['CANONICAL'] = $deepestSection['SECTION_PAGE_URL'] . $arResult['CODE'] . '/';
    }
}

$this->__component->SetResultCacheKeys([
    'ITEM_PRICE',
    'CANONICAL'
]);
$arParams = $component->applyTemplateModifications();