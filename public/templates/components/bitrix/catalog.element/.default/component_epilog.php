<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if(!empty($arResult['CANONICAL'])){
    $APPLICATION->SetPageProperty('canonical', $arResult['CANONICAL']);
}

if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$templateData['TEMPLATE_THEME'].'/style.css');
	$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$templateData['TEMPLATE_THEME'].'/style.css', true);
}

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;

	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

if (isset($templateData['JS_OBJ']))
{
	?>
	<script>
		BX.ready(BX.defer(function(){
			if (!!window.<?=$templateData['JS_OBJ']?>)
			{
				window.<?=$templateData['JS_OBJ']?>.allowViewedCount(true);
			}
		}));
	</script>

	<?
	// check compared state
	if ($arParams['DISPLAY_COMPARE'])
	{
		$compared = false;
		$comparedIds = array();
		$item = $templateData['ITEM'];

		if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]))
		{
			if (!empty($item['JS_OFFERS']))
			{
				foreach ($item['JS_OFFERS'] as $key => $offer)
				{
					if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
					{
						if ($key == $item['OFFERS_SELECTED'])
						{
							$compared = true;
						}

						$comparedIds[] = $offer['ID'];
					}
				}
			}
			elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
			{
				$compared = true;
			}
		}

		if ($templateData['JS_OBJ'])
		{
			?>
			<script>
				BX.ready(BX.defer(function(){
					if (!!window.<?=$templateData['JS_OBJ']?>)
					{
						window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

						<? if (!empty($comparedIds)): ?>
						window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
						<? endif ?>
					}
				}));
			</script>
			<?
		}
	}

	// select target offer
	$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
	$offerNum = false;
	$offerId = (int)$this->request->get('OFFER_ID');
	$offerCode = $this->request->get('OFFER_CODE');

	if ($offerId > 0 && !empty($templateData['OFFER_IDS']) && is_array($templateData['OFFER_IDS']))
	{
		$offerNum = array_search($offerId, $templateData['OFFER_IDS']);
	}
	elseif (!empty($offerCode) && !empty($templateData['OFFER_CODES']) && is_array($templateData['OFFER_CODES']))
	{
		$offerNum = array_search($offerCode, $templateData['OFFER_CODES']);
	}

	if (!empty($offerNum))
	{
		?>
		<script>
			BX.ready(function(){
				if (!!window.<?=$templateData['JS_OBJ']?>)
				{
					window.<?=$templateData['JS_OBJ']?>.setOffer(<?=$offerNum?>);
				}
			});
		</script>
		<?
	}
}?>

<script>
    gtag('event', 'page_view', {
        'send_to': 'AW-938852171',
        'ecomm_pagetype': 'product',
        'ecomm_prodid': '<?=$arResult['VIEWED_PRODUCT']['OFFER_ID'];?>',
        'ecomm_totalvalue': '<?=$arResult['ITEM_PRICE'];?>'
    });
</script>
<?
$itemUrl = 'https://www.'.SITE_SERVER_NAME.''.$arParams["CURRENT_BASE_PAGE"].'';
//echo 'https://www.'.SITE_SERVER_NAME.''.$arParams["CURRENT_BASE_PAGE"];
$conveadItemScript = "try{convead('event', 'view_product', {
    product_id: '".$arResult['ID']."',
    product_name: '".$arResult['NAME']."',
    product_url: '".$itemUrl."'
  });}catch(e){console.log(e);}";
$APPLICATION->AddHeadString('<script type="text/javascript">'.$conveadItemScript.'</script>');
?>