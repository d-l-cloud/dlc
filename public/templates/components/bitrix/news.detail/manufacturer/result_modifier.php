<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Разделы производителя
$brandCategories = [];

$categoriesObj = CIBlockElement::GetList(
    array("SORT"=>"ASC"),
    array("PROPERTY_BRAND" => $arResult['ID']),
    false,
    false,
    array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_LINK', 'PROPERTY_PRODUCT', 'PROPERTY_CATALOG_CATEGORY')
);

while ($category = $categoriesObj->GetNext()) {
    $categoryId = $category['ID'];

    $brandCategories[$categoryId]['name'] = $category['NAME'];
    $brandCategories[$categoryId]['link'] = $category['CODE'];

    $catalogCategoryId = empty($category['PROPERTY_CATALOG_CATEGORY_VALUE']) ? false : $category['PROPERTY_CATALOG_CATEGORY_VALUE'];
    $productIds = empty($category['PROPERTY_PRODUCT_VALUE']) ? [] : $category['PROPERTY_PRODUCT_VALUE'];

    $brandCategories[$categoryId]['product_ids'] = $productIds;

    if ($categoryId) {
        $brandCategories[$categoryId]['catalog_category_id'] = $catalogCategoryId;
    }
}

$arResult['brand_categories'] = $brandCategories;


if (!empty($arResult['PREVIEW_PICTURE'])) {
    $file = CFile::ResizeImageGet(
        $arResult['PREVIEW_PICTURE']['ID'],
        array(
            'width' => 125,
            'height' => 125,
        ),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        false
    );

    $arResult['RESIZED_PREVIEW_PICTURE_LIST_SRC'] = $file['src'];
}