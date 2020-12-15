<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
    $this->setFrameMode(true);

?>
    <div hidden style="display:none">
        <?

            global $arSearchFilter;
            $arSearchFilter = array("PARAMS" => array());
            if (isset($_GET["section"]) && intval($_GET["section"])) {
                $arSearchFilter["PARAMS"]["iblock_section"] = $_GET["section"];
            }

            if (count($arParams['IBLOCK_IDS']))
                $arIBlockList = $arParams["IBLOCK_IDS"];
            if (isset($arResult["ORLND"]["SKU_IBLOCK_ID"]) && isset($arResult["ORLND"]["SKU_IBLOCK_TYPE"]) && ($arResult["ORLND"]["SKU_IBLOCK_TYPE"] == $arParams["IBLOCK_TYPE"]))
                $arIBlockList = array($arParams["IBLOCK_ID"], $arResult["ORLND"]["SKU_IBLOCK_ID"]);
            else
                $arIBlockList = array($arParams["IBLOCK_ID"]);

            $arElements = array();
            $arOffers = array();

            $arElements = $APPLICATION->IncludeComponent(
                "bitrix:search.page",
                "custom_page",
                Array(
                    "RESTART" => $arParams["RESTART"],
                    "NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
                    "USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "arrFILTER" => array("iblock_" . $arParams["IBLOCK_TYPE"]),
                    "arrFILTER_iblock_" . $arParams["IBLOCK_TYPE"] => $arIBlockList,
                    "USE_TITLE_RANK" => "N",
                    "DEFAULT_SORT" => "rank",
                    "FILTER_NAME" => "arSearchFilter",
                    "SHOW_WHERE" => "N",
                    "arrWHERE" => array(),
                    "SHOW_WHEN" => "N",
                    "PAGE_RESULT_COUNT" => 99999,
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "N",
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            ?>
    </div>

<?
//foreach ($arResult["ADDED_ITEMS_IDS"] as $tp) {
//    $arElements[] = $tp;
//}

    if ((is_array($arElements) && !empty($arElements)) || (isset($arOffers) && is_array($arOffers) && !empty($arOffers))) {
        global $searchFilter;

        $searchFilter = array("=ID" => $arElements);

        if (isset($arResult["ORLND"]["SKU_IBLOCK_ID"]) && isset($arResult["ORLND"]["SKU_PROPERTY_SID"])) {

            if (isset($arResult["ORLND"]["SKU_IBLOCK_TYPE"]) && ($arResult["ORLND"]["SKU_IBLOCK_TYPE"] == $arParams["IBLOCK_TYPE"])) {

                $searchFilter = array(
                    array(
                        "LOGIC" => "OR",
                        array("=ID" => $arElements),
                        array(
                            "=ID" => CIBlockElement::SubQuery(
                                "PROPERTY_" . $arResult["ORLND"]["SKU_PROPERTY_SID"],
                                array(
                                    "IBLOCK_ID" => $arResult["ORLND"]["SKU_IBLOCK_ID"],
                                    "=ID" => $arElements
                                )
                            )
                        )
                    )
                );

            } else if (isset($arResult["ORLND"]["SKU_IBLOCK_TYPE"]) && ($arResult["ORLND"]["SKU_IBLOCK_TYPE"] != $arParams["IBLOCK_TYPE"]) && isset($arOffers)) {

                $searchFilter = array(
                    array(
                        "LOGIC" => "OR",
                        array("=ID" => $arElements),
                        array(
                            "=ID" => CIBlockElement::SubQuery(
                                "PROPERTY_" . $arResult["ORLND"]["SKU_PROPERTY_SID"],
                                array(
                                    "IBLOCK_ID" => $arResult["ORLND"]["SKU_IBLOCK_ID"],
                                    "=ID" => $arOffers
                                )
                            )
                        )
                    )
                );

            }
        }

        ?>

	    <article>
		    <div class="search">
                <? if (isset($_GET["q"])) { ?>
                    <h1 class="section-header">Результаты поиска по запросу "<?= $_GET["q"]; ?>"</h1>
                <? } ?>

			    <div class="search-wrap">
                    <? $APPLICATION->IncludeComponent(
                        "custom:catalog.iblocks.section",
                        ".default",
                        array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "IBLOCK_IDS" => $arParams["IBLOCK_IDS"],
                            "SECTION_ID" => "0",
                            "SECTION_CODE" => "",
                            "SECTION_USER_FIELDS" => array(
                                0 => "",
                            ),
                            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                            "FILTER_NAME" => "searchFilter",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "PAGE_ELEMENT_COUNT" => "1000",
                            "PROPERTY_CODE" => array(
                                0 => "CML2_ARTICLE"
                            ),
                            "OFFERS_LIMIT" => "0",
                            "TEMPLATE_THEME" => "blue",
                            "ADD_PICT_PROP" => "-",
                            "LABEL_PROP" => "-",
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
                            "PRODUCT_PROPERTIES" => array(),
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
                            "OFFERS_FIELD_CODE" => array(
                                0 => "",
                            ),
                            "OFFERS_PROPERTY_CODE" => array(
                                0 => "CML2_ATTRIBUTES",
                            ),
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_FIELD2" => "id",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "PRODUCT_DISPLAY_MODE" => "N",
                            "OFFERS_CART_PROPERTIES" => array(),
                        ),
                        false
                    ); ?>
			    </div>
		    </div>
	    </article>
        <?
    } elseif (is_array($arElements)) { ?>
	    <article>
		    <div class="search">
			    <div class=" lk-info__empty">
				    <div class="info-empty__content" style="padding-top: 1%">
					    <img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
					    <div class="info-empty__header">
						    Ничего не найдено
					    </div>
					    <div class="info-empty__redirect">
		                    <? echo GetMessage("CT_BCSE_NOT_FOUND"); ?>
					    </div>
				    </div>
			    </div>
		    </div>
	    </article>
    <? }
?>