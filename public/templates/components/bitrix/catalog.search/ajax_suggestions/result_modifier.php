<?//if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?//
////проверяем есть ли инфоблок с торговыми предложениями для инфоблока с товарами
//$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams["IBLOCK_ID"]);
//if (is_array($arSKU)){
//    //Выбираем свойства, которые удовлетворяют результатам поиска
//    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM");
//    $arFilter = Array(
//        "IBLOCK_ID"=>$arSKU["IBLOCK_ID"],
//        "ACTIVE"=>"Y",
//        //Используем логику "ИЛИ" для поиска по нескольким свойствам
//        array(
//            //Вместо "tpPromo" - символьный код нужного свойства
//            // В данном случае используется поиск с маской по двум свойствам
//            "LOGIC" => "OR",
//            array("PROPERTY_tpPromo" => $_GET["q"]),
//            array("=PROPERTY_tpSale" => substr($_GET["q"], 0, -1)),
//        )
//    );
//    //Получаем результаты поиска
//    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5000), $arSelect);
//    while($ob = $res->GetNextElement()) {
//        $arProps = $ob->GetProperties();
//        //Записываем ID товара к которому привязано торговое предложение
//        $tmp[] = $arProps["CML2_LINK"]["VALUE"];
//    }
//    $tmp = array_unique($tmp);
//    //Возвращаем в arResult полученный массив
//    $arResult["ADDED_ITEMS_IDS"] = $tmp;
//}
//?>
<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?php
$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams["IBLOCK_ID"]);
if (is_array($arSKU)) {
    $arResult["ORLND"]["SKU_IBLOCK_ID"] = $arSKU["IBLOCK_ID"];

    $rsIBlock = CIBlock::GetByID($arSKU["IBLOCK_ID"]);
    if ($arIBlock = $rsIBlock->GetNext())
        $arResult["ORLND"]["SKU_IBLOCK_TYPE"] = $arIBlock["IBLOCK_TYPE_ID"];

    $rsProperty = CIBlockProperty::GetByID($arSKU["SKU_PROPERTY_ID"], $arSKU["IBLOCK_ID"]);
    if ($arProperty = $rsProperty->GetNext())
        $arResult["ORLND"]["SKU_PROPERTY_SID"] = $arProperty["CODE"];
}
