<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
    $arAvailableThemes = array();
    $dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
    if (is_dir($dir) && $directory = opendir($dir))
    {
        while (($file = readdir($directory)) !== false)
        {
            if ($file != "." && $file != ".." && is_dir($dir.$file))
                $arAvailableThemes[] = $file;
        }
        closedir($directory);
    }

    if ($arParams["TEMPLATE_THEME"] == "site")
    {
        $solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
        if ($solution == "eshop")
        {
            $templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
            $templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
            $theme = COption::GetOptionString("main", "wizard_".$templateId."_theme_id", "blue", SITE_ID);
            $arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
        }
    }
    else
    {
        $arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
    }
}
else
{
    $arParams["TEMPLATE_THEME"] = "blue";
}

$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

if(!empty($_GET['sort']) || $_GET['count']){
    $smart_filter_path = '';
    foreach(['sort', 'count'] as $param){
        if(isset($_GET[$param])){
            $smart_filter_path .= '&'.$param.'='.$_GET[$param];
        }
    }

    $arResult['FILTER_AJAX_URL'] = $arResult['FILTER_AJAX_URL'].$smart_filter_path;
    $arResult['FILTER_URL'] = $arResult['FILTER__URL'].$smart_filter_path;
    $arResult["JS_FILTER_PARAMS"]["SEF_SET_FILTER_URL"] = $arResult["JS_FILTER_PARAMS"]["SEF_SET_FILTER_URL"].'?'.trim($smart_filter_path, '&');
}





$allChecked = [];
$result = array();
$url = $arParams['SMART_FILTER_PATH'];
$smartParts = explode("/", $url);
foreach ($smartParts as $smartPart)
{
    if(!$smartPart) continue;
    $smartPart = preg_split("/-(from|to|is|or)-/", $smartPart, -1, PREG_SPLIT_DELIM_CAPTURE);

    $allChecked[reset($smartPart)] = [];
    foreach ($smartPart as $part){
        if(reset($smartPart) == $part) continue;
        if(($part == 'or') || ($part == 'is')) continue;
        $allChecked[reset($smartPart)][] = $part;

    }
}

if(!empty($arParams['SHOW_ONLY']) && is_array($arParams['SHOW_ONLY'])) {
    foreach ($arResult['ITEMS'] as $k => &$items) {
        if (!in_array($items['CODE'], $arParams['SHOW_ONLY'])) {
            unset($arResult['ITEMS'][$k]);
        }
    }
}
unset($items);


foreach ($arResult['ITEMS'] as $k => &$items){

    if(!empty($allChecked[mb_strtolower($items['CODE'])])){
        if(!empty($items['VALUES'])){
            foreach ($items['VALUES'] as &$value){
                if(in_array($value['URL_ID'], $allChecked[mb_strtolower($items['CODE'])] )){
                    $value['CHECKED'] = 1;
                }
            }
        }
    }
}
unset($items);
foreach ($arResult['ITEMS'] as $k => &$items){
    if((empty($items['VALUES']) || empty($items)) && !isset($items['PRICE'])){
        unset($arResult['ITEMS'][$k]);
    }
}
unset($items);

$res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arParams['SECTION_ID']), false, array('UF_SORT_FILTER'));
if($ar_res = $res->GetNext()) {
    foreach (explode(',', $ar_res['UF_SORT_FILTER']) as $v) {
        foreach ($arResult['ITEMS'] as $k => &$items) {
            if ($v == 'PRICE') {
                if ($items['PRICE']) {
                    $sortedValues[$k] = [];
                }
            } else if ($items['CODE'] == $v) {
                $sortedValues[$k] = [];
            }
        }
    }
}
if($sortedValues) {
    foreach ($arResult['ITEMS'] as $k => &$items) {
        $sortedValues[$k] = $items;
    }
    $arResult['ITEMS'] = $sortedValues;
}



