<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$isAjax = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["ajax_action"]) && $_POST["ajax_action"] == "Y");

$allSects = array();
foreach($arResult['ITEMS'] as $arItem) {
    if(!in_array($arItem['IBLOCK_SECTION_ID'], $allSects)) {
        array_push($allSects, $arItem['IBLOCK_SECTION_ID']);
    }
}

$root_section = $_GET['sect'];
if (!in_array($root_section, $allSects)) {
    $root_section = false;
}

if (!$root_section && isset($allSects[0]) && $allSects[0]) {
	$root_section = $allSects[0];
}
?>

<article>
	<div class="compare">
		<?php if (count($allSects) >= 1): ?>
			<h2 class="page-header">Сравнение</h2>
			<div class="compare-sort">
				<div class="features compare-sort-tabs js-tab-change">
                    <?php
                    $arFilter = array('IBLOCK_ID' => 1, 'ID' => $allSects);
                    $rsSections = CIBlockSection::GetList(array('NAME' => 'ASC'), $arFilter, false, array('ID', 'NAME'));
                    while ($arSection = $rsSections->Fetch()): ?>
                        <div class="form_radio_btn">
                            <input id="radio-setup-<?=$arSection['ID']?>" type="radio" name="radio-setup"
	                               <?=($root_section != $arSection['ID']) ? '' : 'checked'?>
                                   value="<?= $arSection['ID'] ?>">
                            <label for="radio-setup-<?=$arSection['ID']?>"><?=$arSection['NAME']?></label>
                        </div>
                    <?php endwhile; ?>
				</div>
			</div>

			<div class="compare-wrap">
                <? if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }
                if ($root_section) {
                    foreach ($arResult['ITEMS'] as $key => $arItem) {
                        if ($arItem['IBLOCK_SECTION_ID'] != $root_section) {
                            unset($arResult['ITEMS'][$key]);
                        }
                    }
                }

                $arH = [];
                $arH_name = [];
                if (!empty($arResult["SHOW_PROPERTIES"])) {
                    foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty) {

                        $showRow = true;
                        if ($arResult['DIFFERENT']) {
                            $arCompare = [];
                            foreach ($arResult["ITEMS"] as $arElement) {
                                $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                                if (is_array($arPropertyValue)) {
                                    sort($arPropertyValue);
                                    $arPropertyValue = implode(" / ", $arPropertyValue);
                                }
                                $arCompare[] = $arPropertyValue;
                            }
                            unset($arElement);
                            $showRow = (count(array_unique($arCompare)) > 1);
                        }

                        if ($showRow) {
                            array_push($arH, $code);
                            array_push($arH_name, $arProperty['NAME']);
                        }
                    }
                }
                ?>


                <?
                $arItemIds = [];
                foreach ($arResult["ITEMS"] as $arItem) {
                    $arItemIds[] = $arItem['ID'];
                }

                global $compareElementFilter;
                $compareElementFilter = [
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                    'ID' => $arItemIds,
                ];?>

			<div class="compare-wrap">
				<button type="button" data-factor="1" class="slick-arrow slick-next arrow-grey compare-arrow"></button>
				<button type="button" data-factor="-1" class="slick-arrow slick-prev arrow-grey compare-arrow"></button>
				<div class="compare-wrap-inner">
	                <?$APPLICATION->IncludeComponent(
	                    "bitrix:catalog.section",
	                    "compare",
	                    [
	                        "COMPONENT_TEMPLATE" => "compare",
	                        "IBLOCK_TYPE" => "cat",
	                        "IBLOCK_ID" => "1",
	                        "IS_INFINITY" => 'N',
	                        "VARIABLE_WIDTH" => 'N',
	                        "IS_COMPARE_LIST" => 'Y',
	                        "SECTION_ID" => "0",
	                        "SECTION_CODE" => "",
	                        "SECTION_USER_FIELDS" => [
	                            0 => "",
	                            1 => "",
	                        ],
	                        "ELEMENT_SORT_FIELD" => "PROPERTY_MOST_POPULAR_HUMAN",
	                        "ELEMENT_SORT_ORDER" => "desc",
	                        "ELEMENT_SORT_FIELD2" => "PROPERTY_MOST_POPULAR_SCRIPT",
	                        "ELEMENT_SORT_ORDER2" => "desc",
	                        "FILTER_NAME" => "compareElementFilter",
	                        "INCLUDE_SUBSECTIONS" => "Y",
	                        "SHOW_ALL_WO_SECTION" => "Y",
	                        "HIDE_NOT_AVAILABLE" => "N",
	                        "PAGE_ELEMENT_COUNT" => "1002",
	                        "PROPERTY_CODE" => [
	                            0 => "CML2_ARTICLE",
	                            1 => "",
	                        ],
	                        "OFFERS_LIMIT" => "0",
	                        "TEMPLATE_THEME" => "blue",
	                        "ADD_PICT_PROP" => "-",
	                        "LABEL_PROP" => [
	                        ],
	                        "PRODUCT_SUBSCRIPTION" => "N",
	                        "SHOW_DISCOUNT_PERCENT" => "Y",
	                        "SHOW_OLD_PRICE" => "Y",
	                        "SHOW_CLOSE_POPUP" => "N",
	                        "MESS_BTN_BUY" => "Купить",
	                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
	                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
	                        "MESS_BTN_DETAIL" => "Подробнее",
	                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
	                        "SECTION_URL" => "",
	                        "DETAIL_URL" => "",
	                        "SECTION_ID_VARIABLE" => "SECTION_ID",
	                        "SEF_MODE" => "N",
	                        "AJAX_MODE" => "N",
	                        "AJAX_OPTION_JUMP" => "N",
	                        "AJAX_OPTION_STYLE" => "Y",
	                        "AJAX_OPTION_HISTORY" => "N",
	                        "AJAX_OPTION_ADDITIONAL" => "",
	                        "CACHE_TYPE" => "A",
	                        "CACHE_TIME" => "36000000",
	                        "CACHE_GROUPS" => "Y",
	                        "SET_TITLE" => "Y",
	                        "SET_BROWSER_TITLE" => "Y",
	                        "BROWSER_TITLE" => "-",
	                        "SET_META_KEYWORDS" => "Y",
	                        "META_KEYWORDS" => "-",
	                        "SET_META_DESCRIPTION" => "Y",
	                        "META_DESCRIPTION" => "-",
	                        "SET_LAST_MODIFIED" => "N",
	                        "USE_MAIN_ELEMENT_SECTION" => "N",
	                        "ADD_SECTIONS_CHAIN" => "N",
	                        "CACHE_FILTER" => "N",
	                        "ACTION_VARIABLE" => "action",
	                        "PRODUCT_ID_VARIABLE" => "id",
	                        "PRICE_CODE" => getUserPriceGroup($USER),
	                        "USE_PRICE_COUNT" => "N",
	                        "SHOW_PRICE_COUNT" => "1",
	                        "PRICE_VAT_INCLUDE" => "Y",
	                        "CONVERT_CURRENCY" => "Y",
	                        "CURRENCY_ID" => "RUB",
	                        "BASKET_URL" => "/personal/cart/",
	                        "USE_PRODUCT_QUANTITY" => "N",
	                        "PRODUCT_QUANTITY_VARIABLE" => "",
	                        "ADD_PROPERTIES_TO_BASKET" => "Y",
	                        "PRODUCT_PROPS_VARIABLE" => "prop",
	                        "PARTIAL_PRODUCT_PROPERTIES" => "Y",
	                        "PRODUCT_PROPERTIES" => [
	                        ],
	                        "ADD_TO_BASKET_ACTION" => "ADD",
	                        "PAGER_TEMPLATE" => ".default",
	                        "DISPLAY_TOP_PAGER" => "N",
	                        "DISPLAY_BOTTOM_PAGER" => "N",
	                        "PAGER_TITLE" => "Товары",
	                        "PAGER_SHOW_ALWAYS" => "N",
	                        "PAGER_DESC_NUMBERING" => "N",
	                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	                        "PAGER_SHOW_ALL" => "N",
	                        "PAGER_BASE_LINK_ENABLE" => "N",
	                        "SET_STATUS_404" => "N",
	                        "SHOW_404" => "N",
	                        "MESSAGE_404" => "",
	                        "SLIDER_HEADER" => "НОВИНКИ",
	                        "OFFERS_FIELD_CODE" => [
	                            0 => "",
	                            1 => "",
	                        ],
	                        "OFFERS_PROPERTY_CODE" => [
	                            0 => "CML2_ATTRIBUTES",
	                            1 => "",
	                        ],
	                        "OFFERS_SORT_FIELD" => "sort",
	                        "OFFERS_SORT_ORDER" => "asc",
	                        "OFFERS_SORT_FIELD2" => "id",
	                        "OFFERS_SORT_ORDER2" => "desc",
	                        "PRODUCT_DISPLAY_MODE" => "N",
	                        "OFFERS_CART_PROPERTIES" => [
	                        ],
	                        "CUSTOM_FILTER" => "",
	                        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
	                        "LINE_ELEMENT_COUNT" => "3",
	                        "PROPERTY_CODE_MOBILE" => [
	                        ],
	                        "BACKGROUND_IMAGE" => "-",
	                        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
	                        "ENLARGE_PRODUCT" => "STRICT",
	                        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
	                        "SHOW_SLIDER" => "Y",
	                        "SLIDER_INTERVAL" => "3000",
	                        "SLIDER_PROGRESS" => "N",
	                        "DISCOUNT_PERCENT_POSITION" => "bottom-right",
	                        "SHOW_MAX_QUANTITY" => "N",
	                        "RCM_TYPE" => "personal",
	                        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
	                        "SHOW_FROM_SECTION" => "N",
	                        "COMPOSITE_FRAME_MODE" => "A",
	                        "COMPOSITE_FRAME_TYPE" => "AUTO",
	                        "DISPLAY_COMPARE" => "N",
	                        "USE_ENHANCED_ECOMMERCE" => "N",
	                        "LAZY_LOAD" => "N",
	                        "LOAD_ON_SCROLL" => "N",
	                        "COMPATIBLE_MODE" => "Y",
	                        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
	                        'shirt_title' => true
	                    ],
	                    false
	                ); ?>

					<div class="compare-char">
						<div class="section-header">Характеристики</div>

						<div class="compare-row">
	                        <? foreach($arResult["ITEMS"] as $eKey => $arElement): ?>
								<div class="compare-char__col">
		                        <? foreach($arH_name as $key => $propName):
		                            $propCode = $arH[$key];

	                                $val = $arElement["DISPLAY_PROPERTIES"][$propCode]["DISPLAY_VALUE"];
	                                if (isset($arElement["DISPLAY_PROPERTIES"][$propCode]["LINK_ELEMENT_VALUE"]) && is_array($arElement["DISPLAY_PROPERTIES"][$propCode]["LINK_ELEMENT_VALUE"])) {
	                                    $arVal = current($arElement["DISPLAY_PROPERTIES"][$propCode]["LINK_ELEMENT_VALUE"]);
	                                    if (isset($arVal["NAME"])) $val = $arVal["NAME"];
	                                }
	                                if (empty($val)) {
	                                    $val = '-';
	                                } ?>
			                        <div class="col-item">
				                        <div class="col-item-header"><?=$propName;?></div>
				                        <div class="col-item-content"><?=$val?></div>
			                        </div>
	                            <? endforeach; ?>
								</div>
	                        <? endforeach; ?>
						</div>
					</div>
				</div>

				<div class="clear-compare js-compare-delete-all">
					Очистить список сравнений
				</div>

                <? if ($isAjax) {
                    die();
                } ?>
			</div>
		<?php else: ?>
			<div class=" lk-info__empty">
				<div class="info-empty__content" style="padding-top: 1%">
					<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
					<div class="info-empty__header">
						Список сравнения пуст
					</div>
					<div class="info-empty__redirect">
						Вы ещё не добавили товары в сравнение
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</article>