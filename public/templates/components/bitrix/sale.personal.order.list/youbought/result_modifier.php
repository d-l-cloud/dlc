<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	use Bitrix\Main\Localization\Loc;

	Loc::loadMessages(__FILE__);

	$arItems = array();
	if(is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"]))
	{
		foreach ($arResult["ORDERS"] as $order) {
            foreach ($order['BASKET_ITEMS'] as $item) {
                $rsItem = CIBlockElement::GetList(array(), array('IBLOCK_ID' => array(1, 2), 'ID' => $item['PRODUCT_ID']));

                if ($arItem = $rsItem->GetNextElement()) {
                    $arItemActive = 'N';

                    $arItemProps = $arItem->GetProperties();
                    $arItemFields = $arItem->GetFields();

                    if ($arItemFields['ACTIVE'] == 'Y') $arItemActive = 'Y';

                    if ($arItemFields["IBLOCK_ID"] == 2) {
                        $arItemParent = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 1, 'ID' => $arItemProps['CML2_LINK']['VALUE']));
                        if ($arItemP = $arItemParent->GetNextElement()) {
                            $arItemFields = $arItemP->GetFields();
                            if ($arItemActive == 'Y' && $arItemFields['ACTIVE'] == 'N') $arItemActive = 'N';
                        }

                    }

                    $sectId = CIBlockSection::GetNavChain($arItemFields['IBLOCK_ID'], $arItemFields["IBLOCK_SECTION_ID"]);
                    if ($sect = $sectId->GetNext()) {
                        $arItems[$sect['ID']]['NAME'] = $sect['NAME'];
                        if (!isset($arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']])) {
                            $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['NAME'] = $item['NAME'];
                            $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['ART'] = $arItemProps['CML2_ARTICLE']['VALUE'];
                            if ($arItemActive == 'Y') $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['PAGE'] = $item['DETAIL_PAGE_URL'];
                            $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['PRICE'] = $item['PRICE'];
                            $arPrice = CCatalogProduct::GetOptimalPrice($item['PRODUCT_ID'], 1, $USER->GetUserGroupArray());
                            if ($arPrice) {
                                $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['CURR_PRICE'] = $arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"];
                                $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['CURRENCY'] = $arPrice["RESULT_PRICE"]["CURRENCY"];
                            } else {
                                $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['CURR_PRICE'] = 0;
                                $arItems[$sect['ID']]['ITEMS'][$item['PRODUCT_ID']]['CURRENCY'] = $item["CURRENCY"];
                            }

                        }
                    }

                }
            }
        }

    }
    
    $arResult = array();
	$arResult['ITEMS'] = $arItems;

    $note = CIBlock::GetArrayByID(1, "DESCRIPTION");

    $arResult['NOTE'] = $note;
?>