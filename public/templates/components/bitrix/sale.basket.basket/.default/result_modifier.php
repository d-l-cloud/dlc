<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;
use Bitrix\Sale;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';

$PREVIEW_WIDTH = intval($arParams["PREVIEW_WIDTH"]);
if ($PREVIEW_WIDTH <= 0)
    $PREVIEW_WIDTH = 125;

$PREVIEW_HEIGHT = intval($arParams["PREVIEW_HEIGHT"]);

foreach ($arResult["GRID"]["ROWS"] as &$arItem){
    if(strlen($arItem["PREVIEW_PICTURE_SRC"]) == 0 && strlen($arItem["DETAIL_PICTURE_SRC"]) == 0){
        $more_photo = CIBlockElement::GetProperty(1, $arItem["PRODUCT_ID"], false, false, Array("CODE"=>"MORE_PHOTO"));
        $gallery = array();
        while ($photo = $more_photo->GetNext())
        {
            $gallery[] = $photo['VALUE'];
        }
        if(!empty($gallery)){
            $arItem["PREVIEW_PICTURE_SRC"] = CFile::ResizeImageGet($gallery[0], array("width"=>$PREVIEW_WIDTH, "height"=>$PREVIEW_HEIGHT), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        }
    }
}