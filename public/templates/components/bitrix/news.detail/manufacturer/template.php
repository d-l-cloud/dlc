<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>

	<article>
		<section class="main-catalog__header">
			<h1 class="page-header"><?= $arResult['NAME'] ?></h1>
			<div class="categories-slide">

			</div>
		</section>

		<section class="brand-catalog">
			<div class="brand-description">
                <? if (!empty($arResult['RESIZED_PREVIEW_PICTURE_LIST_SRC'])): ?>
					<div class="brand-img">
						<img src="<?= $arResult['RESIZED_PREVIEW_PICTURE_LIST_SRC'] ?>" alt="">
					</div>
                <? endif; ?>

				<? if (!empty(trim($arResult['DETAIL_TEXT']))): ?>
					<div class="brand-info-wrap">
						<div class="brand-info">
	                        <?= $arResult['DETAIL_TEXT'] ?>
						</div>
						<div class="brand-info__more">Читать полностью </div>
						<div class="brand-info__less">Скрыть</div>
					</div>
				<? endif; ?>
			</div>

			<?php
            if (!empty($arResult['brand_categories'])) {
                global $brandCategoryFilter;

                foreach ($arResult['brand_categories'] as $brandCategory) {
                    if (!empty($brandCategory['product_ids'])) {
                        $brandCategoryFilter = ['=ID' => $brandCategory['product_ids']];

                        $APPLICATION->IncludeComponent(
                            "custom:catalog.iblocks.section",
                            "slider",
                            array(
                                "IBLOCK_TYPE" => 'cat',
                                "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                                "SECTION_ID" => "0",
                                "SECTION_CODE" => "",
                                "SECTION_USER_FIELDS" => array(
                                    0 => "",
                                ),
                                "ELEMENT_SORT_FIELD" => 'rank',
                                "ELEMENT_SORT_ORDER" => 'desc',
                                "ELEMENT_SORT_FIELD2" => 'shows',
                                "ELEMENT_SORT_ORDER2" => 'desc',
                                "FILTER_NAME" => "brandCategoryFilter",
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
                                "SUB_TITLE" => [
                                    'name' => $brandCategory['name'],
                                    'link' => $brandCategory['link'] . '/',
                                ]
                            ),
                            false
                        );
                    } else if (!empty($brandCategory['catalog_category_id'])) {
                        $brandCategoryFilter = [
                            'PROPERTY_BREND' => $arResult['ID']
                        ];

                        $APPLICATION->IncludeComponent(
                            'bitrix:catalog.section',
                            'manufacturer',
                            [
                                'IBLOCK_TYPE'          => 'cat',
                                'IBLOCK_ID'            => 1,
                                'SECTION_ID'           => $brandCategory['catalog_category_id'],
                                'FILTER_NAME'          => 'brandCategoryFilter',
                                'INCLUDE_SUBSECTIONS'  => 'Y',
                                'CACHE_TYPE'           => 'A',
                                'CACHE_TIME'           => 36000000,
                                'CACHE_GROUPS'         => 'Y',
                                'SET_TITLE'            => 'N',
                                'SET_BROWSER_TITLE'    => 'N',
                                'SET_META_KEYWORDS'    => 'N',
                                'SET_META_DESCRIPTION' => 'N',
                                'BRAND_LINK_FILTER' => 'filter/brend-is-' . strtolower($arResult['NAME']) . '/apply/',
                                'BRAND_CATEGORY_NAME' => $brandCategory['name'],
                                "PRICE_CODE" => getUserPriceGroup($USER),
                                "USE_PRICE_COUNT" => "N",
                                "SHOW_PRICE_COUNT" => "1",
                                "PRICE_VAT_INCLUDE" => "Y",
                                "CONVERT_CURRENCY" => "Y",
                                "CURRENCY_ID" => "RUB",
                            ]
                        );
                    }
                }
            } else {
                global $arrFilter;
                $arrFilter = [
                    'PROPERTY_BREND.ID' => $arResult['ID'],
                ];

                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.section.list',
                    'manufacturer',
                    [
                        'CACHE_GROUPS' => 'Y',
                        'CACHE_TIME'   => '36000000',
                        'CACHE_TYPE'   => 'A',
                        'IBLOCK_ID'    => '1',
                        'IBLOCK_TYPE'  => 'cat',
                        'TOP_DEPTH'    => '1',
                        'BREND'        => mb_strtolower($arResult['NAME']),
                        'BRAND_LINK_FILTER' => 'filter/brend-is-' . strtolower($arResult['NAME']) . '/apply/',
                    ]
                );
            }
			?>
		</section>
	</article>
