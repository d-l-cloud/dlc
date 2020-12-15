<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

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

if (isset($arResult['ITEM'])):
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
	?>
	<div class="video-item">
        <? if ($item['PREVIEW_PICTURE']['SRC']): ?>
			<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>"/>
        <? else: ?>
            <?
            $yurl = '';
            $arTmp = explode("&", $item['PROPERTIES']['VIDEO']['VALUE'][0]);


            foreach($arTmp as $str) {
                if (substr($str, 0, 2) == 'v=') {
                    $str = explode("=", $str);
                    if ($str[1]) {
                        $yurl = $str[1];
                        break;
                    }
                }
            }

            if (!$yurl) {
                $arTmp = explode("?", $item['PROPERTIES']['VIDEO']['VALUE'][0]);
                foreach($arTmp as $str) {
                    if (substr($str, 0, 2) == 'v=') {
                        $str = explode("=", $str);
                        if ($str[1]) {
                            $yurl = $str[1];
                            break;
                        }
                    }
                }
            }
            if ($yurl): ?>
	            <div class="plyr__video-embed js-player" >
		            <iframe
				            src="https://www.youtube.com/embed/<?=$yurl?>"
				            allowfullscreen
				            allowtransparency
				            allow="autoplay"
		            ></iframe>
	            </div>
            <?php endif; ?>
        <?php endif; ?>

		<p class="player-title"><?= $productTitle ?></p>
	</div>
	
<?php endif; ?>
<?php unset($item, $actualItem, $minOffer, $itemIds, $jsParams);