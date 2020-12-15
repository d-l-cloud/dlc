<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

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
		$loadCurrency = \Bitrix\Main\Loader::includeModule('currency');
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

//	lazy load and big data json answers
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('action') === 'showMore' || $request->get('action') === 'deferredLoad'))
{
	$content = ob_get_contents();
	ob_end_clean();

	list(, $itemsContainer) = explode('<!-- items-container -->', $content);
	list(, $paginationContainer) = explode('<!-- pagination-container -->', $content);

	if ($arParams['AJAX_MODE'] === 'Y')
	{
		$component->prepareLinks($paginationContainer);
	}

	$component::sendJsonAnswer(array(
		'items' => $itemsContainer,
		'pagination' => $paginationContainer
	));
}

if (!defined('ERROR_404')){
	/*$arResult['URL'] = "/katalog/".$arResult['SECTION_CODE'];

	if ($arResult['NAV_PAGE_NOMER']>1) {
		$APPLICATION->AddHeadString('<link rel="canonical" href="http://' . $_SERVER["HTTP_HOST"] . $arResult['URL'] . '">');
	}*/


	$protocol = ($APPLICATION->IsHTTPS() ? 'https://' : 'http://');
	if (isset($arResult['NAV_NUM'], $arResult['NAV_PAGE_NOMER'], $arResult['NAV_PAGE_COUNT'], $arResult['URL'])){
		if ($arResult['NAV_PAGE_COUNT'] > $arResult['NAV_PAGE_NOMER']) { // rel next
			$next = $arResult['NAV_PAGE_NOMER'] + 1;
			$urlNextRel = $arResult['URL']."?PAGEN_1=".$next;       
		} 
		if ($arResult['NAV_PAGE_NOMER'] > 1) { // rel prev
			$prev = $arResult['NAV_PAGE_NOMER'] - 1;
			If($prev > 1){
				$urlPrevRel = $arResult['URL']."?PAGEN_1=".$prev; 
			}
			else{
				$urlPrevRel = $arResult['URL'];
			}
		} 
		if (isset($urlNextRel)) {
			// $APPLICATION->SetPageProperty('next', $protocol . $_SERVER["HTTP_HOST"] . $urlNextRel);
			$APPLICATION->AddHeadString('<link rel="next" href="' . $protocol .$_SERVER["HTTP_HOST"].$urlNextRel . '">');
		} 
		if (isset($urlPrevRel)) {
			// $APPLICATION->SetPageProperty('prev', $protocol . $_SERVER["HTTP_HOST"] . $urlPrevRel);
			$APPLICATION->AddHeadString('<link rel="prev" href="' . $protocol .$_SERVER["HTTP_HOST"].$urlPrevRel . '">');
		} 
	}
}