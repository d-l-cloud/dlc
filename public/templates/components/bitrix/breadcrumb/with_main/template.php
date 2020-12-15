<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult)) {
    return "";
}


$arCrumbs = [];

$strReturn = '';
$crumbIndex = 1;

$arCrumbs[] = [
    'TITLE' => 'Главная',
    'LINK' => '/',
];


$itemSize = count($arResult);

for ($index = 0; $index < $itemSize; $index++) {
    if ($arResult[$index]["LINK"] == '/katalog/katalog/') {
        continue;
    }

    $crumbIndex++;
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    $arCrumbs[] = [
        'TITLE' => $title,
        'LINK' => $arResult[$index]["LINK"],
    ];
}

$strReturn .= '<div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList">';

foreach ($arCrumbs as $index => $arCrumb) {
    if ($arCrumb["LINK"] <> "" && $index != $itemSize) {
        $strReturn .= '<a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="'.$arCrumb['LINK'].'">'.$arCrumb['TITLE'].'</a>';
    } else {
        $strReturn .= '<div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'.$arCrumb['TITLE'].'</div>';
    }
}

$strReturn .= '</div>';

return $strReturn;