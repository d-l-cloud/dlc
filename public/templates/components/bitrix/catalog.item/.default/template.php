<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

if (isset($arResult['ITEM'])) {
	$item = $arResult['ITEM'];

	$areaId = $arResult['AREA_ID'];

	$itemIds = array(
		'ID' => $areaId,
		'PICT' => $areaId.'_pict',
		'SECOND_PICT' => $areaId.'_secondpict',
		'PICT_SLIDER' => $areaId.'_pict_slider',
		'STICKER_ID' => $areaId.'_sticker',
		'SECOND_STICKER_ID' => $areaId.'_secondsticker',
		'QUANTITY' => $areaId.'_quantity',
		'QUANTITY_DOWN' => $areaId.'_quant_down',
		'QUANTITY_UP' => $areaId.'_quant_up',
		'QUANTITY_MEASURE' => $areaId.'_quant_measure',
		'QUANTITY_LIMIT' => $areaId.'_quant_limit',
		'BUY_LINK' => $areaId.'_buy_link',
		'BASKET_ACTIONS' => $areaId.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $areaId.'_not_avail',
		'SUBSCRIBE_LINK' => $areaId.'_subscribe',
		'COMPARE_LINK' => $areaId.'_compare_link',
		'PRICE' => $areaId.'_price',
		'PRICE_OLD' => $areaId.'_price_old',
		'PRICE_TOTAL' => $areaId.'_price_total',
		'DSC_PERC' => $areaId.'_dsc_perc',
		'SECOND_DSC_PERC' => $areaId.'_second_dsc_perc',
		'PROP_DIV' => $areaId.'_sku_tree',
		'PROP' => $areaId.'_prop_',
		'DISPLAY_PROP_DIV' => $areaId.'_sku_prop',
		'BASKET_PROP_DIV' => $areaId.'_basket_prop',
	);

	$obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
	$isBig = isset($arResult['BIG']) && $arResult['BIG'] === 'Y';

	$productTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $item['NAME'];

	$imgTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $item['NAME'];

	$skuProps = array();

	$haveOffers = !empty($item['OFFERS']);
	$offersCount = 0;
	if ($haveOffers) {
        if (isset($item['OFFERS'][$item['OFFERS_SELECTED']])) {
            $actualItem = $item['OFFERS'][$item['OFFERS_SELECTED']];
        } else {
            $minPriceTmp = false;
            foreach ($item['OFFERS'] as $key => $offer) {
                $price = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                if($minPriceTmp === false || $minPriceTmp > $price){
                    $minPriceTmp = $price;
                    $actualItem = $offer;
                }
            }
        }

        $offersCount = count($item['OFFERS']);
	} else {
		$actualItem = $item;
	}

	if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers) {
		$price = $item['ITEM_START_PRICE'];
		$minOffer = $item['OFFERS'][$item['ITEM_START_PRICE_SELECTED']];
		$measureRatio = $minOffer['ITEM_MEASURE_RATIOS'][$minOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
		$quantity = $minOffer['CATALOG_QUANTITY'];
	}

	if (!$price) {
		$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
		$measureRatio = $price['MIN_QUANTITY'];
		$quantity = $actualItem['CATALOG_QUANTITY'];
	}

	$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($item['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

	if ($brend_id = $item["PROPERTIES"]["BREND"]["VALUE"]) {
		$res = CIBlockElement::GetList(
            array(),
            array("IBLOCK_ID" => 3, "ID" => $brend_id),
            false,
            array("nTopCount" => 1),
            array("NAME", "PREVIEW_PICTURE", "PROPERTY_LINK")
        );

		$arBrend = $res->GetNext();
	}

    if (!empty($arParams['shirt_title']) && mb_strlen($productTitle) > 65) {
        $productTitle = mb_substr($productTitle, 0, 65) . '...';
    }

    ?>
	<div class="item <?= $arResult['BLOCK_CLASS'] ?>">
		<div class="item-img">

            <?if($actualItem['CATALOG_AVAILABLE'] != "Y" || empty($actualItem['CATALOG_QUANTITY'])): ?>
	            <!--<div class="item-not-available">
		            <div class="item-more__none">
			            Нет в Наличии
		            </div>
	            </div>-->
            <?php else: ?>
	            <div class="item-img__more">
		            <div class="item-more__tools">
                        <?php if(isset($actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']) && $actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
				            <div class="item-number">
					            Арт: <?= str_replace(['*', '#'], '',$actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']); ?>
				            </div>
                        <?php endif?>
			            <div class="item-interest">
                            <?php if ($arParams['IS_COMPARE_LIST'] != 'Y'): ?>
					            <div class="item-compare fav-comp js-item-compare"
					                 data-product_id="<?= $item['ID']; ?>"
					                 data-iblock="<?= $item["IBLOCK_ID"] ?>">
						            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
							            <rect x="6" y="14" width="8" height="12" rx="3" stroke="#1F3664" stroke-width="2"/>
							            <rect x="18" y="6" width="8" height="20" rx="3" stroke="#1F3664" stroke-width="2"/>
						            </svg>
					            </div>
                            <?php endif?>
                            <?php if ($arParams['IS_FAVORITE_LIST'] != 'Y'): ?>
					            <div class="item-favourites fav-heart js-item-favourites" data-product_id="<?= $item['ID']; ?>">
						            <svg width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							            <path d="M11.281 4.10271L12 4.84663L12.719 4.10271L14.2099 2.56023C16.2206 0.479926 19.4951 0.479927 21.5058 2.56023C23.4981 4.62143 23.4981 7.94965 21.5058 10.0108L12 19.8458L2.49417 10.0108C0.501943 7.94964 0.501944 4.62142 2.49417 2.56023C4.50487 0.479923 7.77941 0.479925 9.7901 2.56023L11.281 4.10271Z" stroke="#1F3664" stroke-width="2"/>
						            </svg>
					            </div>
                            <?php endif?>
			            </div>
		            </div>
		            <div class="fast-look js-open-fast-review" data-product_id="<?=$item["ID"]?>">
			            Быстрый просмотр
		            </div>
	            </div>
            <?php endif; ?>
            <?php if(!empty($item['RESIZED_PREVIEW_PICTURE_LIST_SRC'])): ?>
	            <a class="img-link" href="<?=$item['DETAIL_PAGE_URL'] ?>">
		            <img src="<?=$item['RESIZED_PREVIEW_PICTURE_LIST_SRC']?>" alt="<?=$imgTitle?>">
	            </a>
            <?php else: ?>
	            <a class="img-link" href="<?=$item['DETAIL_PAGE_URL'] ?>">
		            <img src="/foto_not_found_290.jpg" alt="Изображение не найдено">
	            </a>
            <?php endif; ?>
		</div>
		<div class="item-price">
			<div class="item-price__current"><?= $price['PRINT_RATIO_PRICE'] ?></div>

            <?if($arParams['SHOW_OLD_PRICE'] === 'Y' && $price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE']):?>
				<div class="item-price__old" id="<?=$itemIds['PRICE_OLD']?>">
                    <?=$price['PRINT_RATIO_BASE_PRICE']?>
				</div>
            <?endif?>

            <?php if($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && $price['PERCENT'] > 0): ?>
				<div class="item-price__discount">-<?= $price['PERCENT'] ?>%</div>
			<?php endif; ?>
		</div>
		<a href="<?=$item['DETAIL_PAGE_URL'] ?>" class="item-description">
			<?= $productTitle; ?>
		</a>
		<div class="item-buy">
            <?php
            $smallImgUrl = '/foto_not_found_290.jpg';
            if(!empty($item['RESIZED_PREVIEW_PICTURE_LIST_SRC'])) {
            	$smallImgUrl = $item['RESIZED_PREVIEW_PICTURE_LIST_SRC'];
            }
            ?>
		    <?if($actualItem['CATALOG_AVAILABLE'] != "Y" || empty($actualItem['CATALOG_QUANTITY'])): ?>
		    <?php else: ?>
			    <div class="item-buy__btn js_add_to_cart js_product_list"
			         data-product_id="<?= $actualItem['ID']; ?>"
			         data-img="<?=$smallImgUrl?>"
			         data-title="<?= $productTitle; ?>">Купить</div>
		    <?php endif; ?>

			<?php if ($arParams['IS_FAVORITE_LIST'] == 'Y'): ?>
				<div class="fav-del-btn js-favorite-delete" data-product_id="<?=$item["ID"]?>" data-iblock="<?=$item["IBLOCK_ID"]?>">Удалить</div>
            <?php elseif ($arParams['IS_COMPARE_LIST'] == 'Y'): ?>
				<div class="fav-del-btn js-compare-delete" data-product_id="<?=$item["ID"]?>" data-iblock="<?=$item["IBLOCK_ID"]?>">Удалить</div>
            <?php else: ?>
                <?if($actualItem['CATALOG_AVAILABLE'] != "Y" || empty($actualItem['CATALOG_QUANTITY'])): ?>
                <?php else: ?>
					<div class="item-buy__click js-load-web-form-pop-up"
					     data-web_form_text_id="buy_one_click"
					     data-prod_href="<?=$item['DETAIL_PAGE_URL']?>"
					     data-article="<?=$actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']?>">Купить в 1 клик</div>
                <?php endif; ?>
            <?php endif; ?>
		</div>
		<?php if(!empty($item['OFFERS']) && $item['CATALOG_AVAILABLE'] == "Y" && count($item['OFFERS']) > 1): ?>
			<a href="<?=$item['DETAIL_PAGE_URL'] ?>" class="item-variants">Еще <?= count($item['OFFERS']) - 1; ?> <?= wordCountEndings(count($item['OFFERS']) - 1, 'вариант', 'варианта', 'вариантов') ?></a>
        <?php endif; ?>
	</div>
	<?
	unset($item, $actualItem, $minOffer, $itemIds, $jsParams);
}