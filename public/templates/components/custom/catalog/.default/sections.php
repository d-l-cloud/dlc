<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
	$basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}
?>

<?
    $arUrl = explode("/", $_SERVER['REQUEST_URI']);

    // Мета теги и h1 заголовок
    $smartCategorySeo = [
        'h1_title' => 'Каталог',
        'meta_description' => '',
        'meta_title' => 'Каталог'
    ];

    if (!empty($arUrl[3])) {
        $smartCategory = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => 5,
                'CODE' => str_replace('complect-is-', '', $arUrl[3])
            ],
            false,
            false,
            [
                'ID',
                'NAME',
                'CODE',
                'DETAIL_TEXT'
            ]
        )->Fetch();

        if (!empty($smartCategory)) {

            if(!empty($smartCategory['DETAIL_TEXT'])) {
                $this->SetViewTarget('catalog_descr');
                echo $smartCategory['DETAIL_TEXT'];
                $this->EndViewTarget();
            }

            $elementSeoValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(5, $smartCategory['ID']);

            $smartCategoryElementSeo = $elementSeoValues->getValues();

            if (!empty($smartCategoryElementSeo['ELEMENT_PAGE_TITLE'])) {
                $smartCategorySeo['h1_title'] = $smartCategoryElementSeo['ELEMENT_PAGE_TITLE'];
            }

            if (!empty($smartCategoryElementSeo['ELEMENT_META_TITLE'])) {
                $smartCategorySeo['meta_description'] = $smartCategoryElementSeo['ELEMENT_META_DESCRIPTION'];
            }

            if (!empty($smartCategoryElementSeo['ELEMENT_META_TITLE'])) {
                $smartCategorySeo['meta_title'] = $smartCategoryElementSeo['ELEMENT_META_TITLE'];
            }
        }
    }

    $APPLICATION->SetPageProperty('description', $smartCategorySeo['meta_description']);
    $APPLICATION->SetPageProperty('title', $smartCategorySeo['meta_title']);
    $APPLICATION->SetTitle($smartCategorySeo['h1_title']);
?>

<article>
	<section class="main-catalog__header">
		<h1 class="page-header"><?=$APPLICATION->ShowTitle(false)?></h1>
	</section>
	<?
        $APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => 0,
				"SECTION_CODE" => '',
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
				"FROM_ROOT" => 1
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);
	?>
	<section class="main-catalog">
		<div class="main-catalog-wrap">
			<?
			   $set = 0;
			   $smart_filter_path = '';

			    foreach ($arUrl as $item) {
			        if ($item == 'filter') {
			            $set = 1;
			        } elseif ($item == 'apply') {
			            $set = 0;
			            break;
			        } elseif ($set) {
			            $smart_filter_path .= $item . '/';
			        }
			    }

			    $_REQUEST['SMART_FILTER_PATH'] = $smart_filter_path;

                $showOnFilter = array("Розничная сайт", "BREND", "COMPLECT");
			    ?>
			    <?php
			    $APPLICATION->IncludeComponent(
			        "custom:catalog.smart.filter",
			        "",
			        array(
			            "IBLOCK_TYPE"           => $arParams["IBLOCK_TYPE"],
			            "IBLOCK_ID"             => $arParams["IBLOCK_ID"],
			            "SECTION_ID"            => 0,
			            "SECTION_CODE"          => '',
			            "FILTER_NAME"           => $arParams["FILTER_NAME"],
			            "PRICE_CODE"            => $arParams["~PRICE_CODE"],
			            "CACHE_TYPE"            => $arParams["CACHE_TYPE"],
			            "CACHE_TIME"            => $arParams["CACHE_TIME"],
			            "CACHE_GROUPS"          => $arParams["CACHE_GROUPS"],
			            "SAVE_IN_SESSION"       => "N",
			            "FILTER_VIEW_MODE"      => $arParams["FILTER_VIEW_MODE"],
			            "XML_EXPORT"            => "N",
			            "SECTION_TITLE"         => "NAME",
			            "SECTION_DESCRIPTION"   => "DESCRIPTION",
			            'HIDE_NOT_AVAILABLE'    => 'N',//$arParams["HIDE_NOT_AVAILABLE"],
			            "TEMPLATE_THEME"        => $arParams["TEMPLATE_THEME"],
			            'CONVERT_CURRENCY'      => $arParams['CONVERT_CURRENCY'],
			            'CURRENCY_ID'           => $arParams['CURRENCY_ID'],
			            "SEF_MODE"              => $arParams["SEF_MODE"],
			            "SEF_RULE"              => '/katalog/filter/#SMART_FILTER_PATH#/apply',
			            "SMART_FILTER_PATH"     => $_REQUEST['SMART_FILTER_PATH'],
			            "PAGER_PARAMS_NAME"     => $arParams["PAGER_PARAMS_NAME"],
			            "INSTANT_RELOAD"        => $arParams["INSTANT_RELOAD"],
			            "DISPLAY_ELEMENT_COUNT" => "N",
			            "SHOW_ALL_WO_SECTION"   => "Y",
                        "SHOW_ONLY" => $showOnFilter,
			        ),
			        $component,
			        array('HIDE_ICONS' => 'Y')
			    );
			    ?>

            <? $count = getProductListCount();
            $sort=(isset($_GET['sort'])) ? $_GET['sort'] : 'sort_asc';
            list($sortField, $sortOrder)=explode('_', $sort);
            if(!$sortField) $sortField='sort';
            else {
                if ($sortField == 'price')  {
                    $productId = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 1, 'CATALOG_TYPE' => 1, 'ACTIVE' => 'Y'), false, false, array('ID'))->Fetch()['ID'];
                    $price = CCatalogProduct::GetOptimalPrice($productId, 1, $USER->GetUserGroupArray(), $renewal);
                    $sortField = "catalog_PRICE_".$price['PRICE']['CATALOG_GROUP_ID'];
                }
            }
            if(!$sortOrder) $sortOrder='asc';


            $intSectionID = $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "ELEMENT_SORT_FIELD" => $sortField,
                    "ELEMENT_SORT_ORDER" => $sortOrder,
                    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["~MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $count,
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["~PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                    "SECTION_ID" => '',
                    "SECTION_CODE" => '',
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                    'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                    'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                    'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                    'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                    'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                    'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                    'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                    'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                    'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                    'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                    'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                    'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                    'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                    'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                    'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                    'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                    'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    "ADD_SECTIONS_CHAIN" => "N",
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                    'USE_COMPARE_LIST' => 'Y',
                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                    'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                ),
                $component
            );
            ?>
            <?$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;?>
		</div>
	</section>
</article>


<section>
	<div class="subscribe">
		<div class="subscribe-col">
			<div class="subscribe-header">
			</div>
			<div class="subscribe-text">
                <?php if ($sNewDescription = \Local\DescriptionOnPage::getPageDescription($APPLICATION->GetCurPage())) : ?>
                    <?= $sNewDescription ?>
                <?php else: ?>
                    <? $APPLICATION->ShowViewContent('catalog_descr'); ?>
                <?php endif; ?>
			</div>
		</div>
        <?php $APPLICATION->IncludeComponent(
            "custom:subscribe.edit",
            "",
            array(
                "COMPONENT_TEMPLATE" => ".default",
                "SHOW_HIDDEN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "ALLOW_ANONYMOUS" => "Y",
                "SHOW_AUTH_LINKS" => "N",
                "SET_TITLE" => "N"
            ),
            false
        ); ?>
	</div>
</section>
