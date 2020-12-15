<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);

if (!empty($arResult['ITEMS'])):
    foreach ($arResult['ITEMS'] as $item):
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

	    ?>
	    <a class="search-results__item" href="<?= $item["DETAIL_PAGE_URL"] ?>">
		    <div class="search-results__col">
			    <img src="<?= $item['RESIZED_PREVIEW_PICTURE_SRC'] ?>" alt="">
		    </div>
		    <div class="search-results__col">
			    <div class="search-results__name"><?= $item["NAME"] ?></div>
			    <div class="search-results__price">
                    <?= $price['PRINT_RATIO_PRICE'] ?>
                    <?php if($arParams['SHOW_OLD_PRICE'] === 'Y' && $price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE']): ?>
					    <span class="search-price__old">
						    <?= $price['PRINT_RATIO_BASE_PRICE'] ?>
	                        <?php if($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && $price['PERCENT'] > 0):?>
						        <div class="item-price__discount search-discount">-<?= $price['PERCENT'] ?>%</div>
	                        <?php endif; ?>
					    </span>
                    <?php endif; ?>
			    </div>
		    </div>
	    </a>
    <?php endforeach;
    if (count($arResult['ITEMS']) >= $arParams['PAGE_ELEMENT_SHOW'] && !empty($_REQUEST['q'])): ?>
	    <a class="search-results__all" onclick="$('#title-search .search-btn').click()">
		    Все результаты
	    </a>
    <?php endif;
endif;
