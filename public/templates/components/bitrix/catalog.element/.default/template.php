<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}


unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);

$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);

$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];

$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];

$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$APPLICATION->SetPageProperty('title', $title);

$haveOffers = !empty($arResult['OFFERS']);

if ($haveOffers) {
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);

    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
            break;
        }
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';

if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';

if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

if ($brend_id = $arResult["PROPERTIES"]["BREND"]["VALUE"]) {
    $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $brend_id), false, array("nTopCount" => 1), array("NAME", "PREVIEW_PICTURE", "PROPERTY_LINK"));
    $arBrend = $res->GetNext();
}

$arResult["MORE_PHOTO"] = array();

if (isset($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && is_array($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
    foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $FILE) {
        $FILE = CFile::GetFileArray($FILE);

        if (is_array($FILE)) {
            $arResult["MORE_PHOTO"][]=$FILE;
        }
    }
} else if (isset($arResult['DETAIL_PICTURE'])) {
    array_unshift($arResult['MORE_PHOTO'], $arResult['DETAIL_PICTURE']);
}


$offers_select_variant_property_ids = $offers_technical_property_ids = $product_technical_property_ids = [];

if (CModule::IncludeModule('yenisite.infoblockpropsplus')) {
    // Собираем id свойств основного каталога, которые должны попасть в список "Технические характеристики".
    $arInitArray = CYenisiteInfoblockpropsplus::GetInitArray(
        array(
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            'SECTION_ID' => -1
        )
    );

    if (!empty($arInitArray['PROPS_TO_GROUPS'])) {
        foreach ($arInitArray['PROPS_TO_GROUPS'] as $properties) {
            foreach ($properties as $property) {
                if (preg_match('/^Tech_char_(.*)/', $property['GROUP_NAME'], $matches)) {
                    $product_technical_property_ids[$property['PROPERTY_ID']] = [
                        'sort' => $property['SORT'],
                        'comment' => $arInitArray['PROPS_COMMENTS'][$property['PROPERTY_ID']]
                    ];
                }
            }
        }
    }

    // Собираем id свойств торговых предложений с группами выбора варианта, технических характеристик
    $arInitArray = CYenisiteInfoblockpropsplus::GetInitArray(
        array(
            'IBLOCK_ID' => OFFERS_IBLOCK_ID,
            'SECTION_ID' => -1
        )
    );

    if (!empty($arInitArray['PROPS_TO_GROUPS'])) {
        foreach ($arInitArray['PROPS_TO_GROUPS'] as $properties) {
            foreach ($properties as $property) {
                if (preg_match('/^Variant_char_(.*)/', $property['GROUP_NAME'], $matches)) {
                    $offers_select_variant_property_ids[$property['PROPERTY_ID']] = [
                        'sort' => $property['SORT'],
                        'comment' => $arInitArray['PROPS_COMMENTS'][$property['PROPERTY_ID']]
                    ];
                } else if (preg_match('/^Tech_char_(.*)/', $property['GROUP_NAME'], $matches)) {
                    $offers_technical_property_ids[$property['PROPERTY_ID']] = [
                        'sort' => $property['SORT'],
                        'comment' => $arInitArray['PROPS_COMMENTS'][$property['PROPERTY_ID']]
                    ];
                }
            }
        }
    }
}

$technicalProperties = [];

foreach ($arResult['PROPERTIES'] as $key => $property) {
    if (isset($product_technical_property_ids[$property['ID']])) {
        $property['comment'] = $product_technical_property_ids[$property['ID']]['comment'];
        $technicalProperties[$key] = $property;
    }
}

if ($haveOffers) {
    $arOffersProps = [];
    $arVariantProps = [];
    $offersTechProps = [];
    $noProp = [];
    $iter = 0;

    $usedProps = [];

    foreach ($arResult['OFFERS'] as $keyOffer => $arOffer) {
        foreach($arOffer['PROPERTIES'] as $arProp) {
            if($arProp['VALUE'] && $arProp['PROPERTY_TYPE'] == 'L' && $arProp['CODE'] != 'COLOR') {
                $usedProps[$arProp['CODE']] = $arProp['CODE'];
            }
        }
    }

    foreach ($arResult['OFFERS'] as $keyOffer => $arOffer) {
        $variant = '';

        if (isset($arOffer['PROPERTIES']['COLOR'])) {
            $arTmp = array("COLOR" => $arOffer['PROPERTIES']['COLOR']);
            unset($arOffer['PROPERTIES']['COLOR']);
            $arOffer['PROPERTIES'] = array_merge($arTmp, $arOffer['PROPERTIES']);
        }

        foreach ($arOffer['PROPERTIES'] as $k => $arProp) {
            if (!isset($noProp[$k])) {
                $noProp[$k] = rand(11111, 99999);
            }

            // если у торгового предложения не заполнено свойство заполненное у других предложений,
            // то ставим свойству значение "нет"
            if ((!$arProp['VALUE'] || mb_strtolower($arProp['VALUE']) === 'нет')
                && $usedProps[$arProp['CODE']]
            ) {
                $arProp['VALUE'] = 'Нет';
                $arResult['OFFERS'][$keyOffer]['PROPERTIES'][$k]['VALUE'] = 'Нет';
                $arResult['OFFERS'][$keyOffer]['PROPERTIES'][$k]['VALUE_ENUM_ID'] = $arProp['VALUE_ENUM_ID'] = $noProp[$k] ;
            }

            // строковым свойствам ставим VALUE_ENUM_ID для корректной работы радиокнопок
            if ($arProp['PROPERTY_TYPE'] == 'S' && !$arProp['VALUE_ENUM_ID']) {
                $arResult['OFFERS'][$keyOffer]['PROPERTIES'][$k]['VALUE_ENUM_ID'] = $arProp['VALUE_ENUM_ID'] = md5($arProp['VALUE']);
            }

            if ($arProp['CODE'] == 'CML2_LINK'
                || $arProp['CODE'] == 'CML2_ARTICLE'
                || $arProp['CODE'] == 'MORE_PHOTO'
            ) {
                continue;
            }

            if ($arProp['VALUE']) {
                // У торговых предложений свойства в список технических характеристик попадают из обеих групп
                $isSelectVariantProperty = isset($offers_select_variant_property_ids[$arProp['ID']]);
                $isTechnicalProperty = isset($offers_technical_property_ids[$arProp['ID']]);

                if ($isSelectVariantProperty) {
                    $offersTechProps[$arProp['CODE']] = $offers_select_variant_property_ids[$arProp['ID']]['comment'];
                } else if ($isTechnicalProperty) {
                    $offersTechProps[$arProp['CODE']] = $offers_technical_property_ids[$arProp['ID']]['comment'];
                }

                if ($isSelectVariantProperty) {
                    if (!isset($arOffersProps[$arProp['CODE']])) {
                        $arOffersProps[$arProp['CODE']] = array(
                            'NAME' => $arProp['NAME'],
                            "VALUES" => array()
                        );
                    }

                    if (!$arProp['VALUE_SORT']) {
                        $arProp['VALUE_SORT'] = ++$iter;
                    }

                    if ($arProp['CODE'] == 'COLOR') {
                        if (!in_array($arProp['VALUE_XML_ID'], $arOffersProps[$arProp['CODE']]["VALUES"])) {
                            $arOffersProps[$arProp['CODE']]["VALUES"][$arProp['VALUE_XML_ID']] = array(
                                "VALUE" => $arProp['VALUE_XML_ID'],
                                "SORT" => $arProp['VALUE_SORT'],
                                "NAME" => $arProp['VALUE'],
                                "VALUE_ENUM_ID" => $arProp['VALUE_ENUM_ID']
                            );
                        }
                    } else {
                        if (!in_array($arProp['VALUE'], $arOffersProps[$arProp['CODE']]["VALUES"])) {
                            $arOffersProps[$arProp['CODE']]["VALUES"][$arProp['VALUE']] = array(
                                "VALUE" => $arProp['VALUE'],
                                "SORT" => $arProp['VALUE_SORT'],
                                "VALUE_ENUM_ID" => $arProp['VALUE_ENUM_ID']
                            );
                        }
                    }

                    if ($arProp['CODE'] !== 'FACTORY_ITEM') {
                        $variant .= $arProp['CODE'] . ':' . $arProp['VALUE_ENUM_ID'] . '|';
                    }

                    if (!in_array($arProp['CODE'], $arVariantProps)) {
                        array_push($arVariantProps, $arProp['CODE']);
                    }
                }
            }
        }

        foreach ($offersTechProps as $code => $comment) {
            if (isset($technicalProperties[$code])) {
                $technicalProperties[$code]['OFFER_VALUES'][$variant] = $arOffer['PROPERTIES'][$code]['VALUE'];
                $technicalProperties[$code]['comment'] = $comment;
            } else {
                $property = $arOffer['PROPERTIES'][$code];
                $property['OFFER_VALUES'][$variant] = $arOffer['PROPERTIES'][$code]['VALUE'];
                $property['comment'] = $comment;

                $technicalProperties[$code] = $property;
            }
        }

        $arResult['OFFERS'][$keyOffer]['VARIANT'] = $variant;
    }

    // Габариты и вес торговых предложений нужно добавить в конец массива технических характеристик
    foreach ($arResult['OFFERS'] as $keyOffer => $arOffer) {
        if (!empty($arOffer['CATALOG_WIDTH']) && !empty($arOffer['CATALOG_LENGTH']) && !empty($arOffer['CATALOG_HEIGHT'])) {
            $widthCm = $arOffer['CATALOG_WIDTH'] / 10;
            $lengthCm = $arOffer['CATALOG_LENGTH'] / 10;
            $heightCm = $arOffer['CATALOG_HEIGHT'] / 10;

            $dimensionsCmString = $lengthCm . 'x' . $widthCm . 'x' . $heightCm;

            if (!isset($technicalProperties['CATALOG_DIMENSIONS'])) {
                $technicalProperties['CATALOG_DIMENSIONS'] = [
                    'NAME' => 'Размер (ДхШхВ), см',
	                'SORT' => '999998',
                    'OFFER_VALUES' => [
                        $arOffer['VARIANT'] => $dimensionsCmString
                    ],
                ];
            } else {
                $technicalProperties['CATALOG_DIMENSIONS']['OFFER_VALUES'][$arOffer['VARIANT']] = $dimensionsCmString;
            }
        }

        if (!empty($arOffer['CATALOG_WEIGHT'])) {
            $weightKg = $arOffer['CATALOG_WEIGHT'] / 1000;

            if (!isset($technicalProperties['CATALOG_WEIGHT'])) {
                $technicalProperties['CATALOG_WEIGHT'] = [
                    'NAME' => 'Вес, кг',
                    'SORT' => '999999',
                    'OFFER_VALUES' => [
                        $arOffer['VARIANT'] => $weightKg
                    ],
                ];
            } else {
                $technicalProperties['CATALOG_WEIGHT']['OFFER_VALUES'][$arOffer['VARIANT']] = $weightKg;
            }
        }
    }
} else {
    // Габариты товара нужно добавить в конец массива технических характеристик
    if (!empty($arResult['CATALOG_WIDTH']) && !empty($arResult['CATALOG_LENGTH']) && !empty($arResult['CATALOG_HEIGHT'])) {
        $widthCm = $arResult['CATALOG_WIDTH'] / 10;
        $lengthCm = $arResult['CATALOG_LENGTH'] / 10;
        $heightCm = $arResult['CATALOG_HEIGHT'] / 10;

        $dimensionsCmString = $lengthCm . 'x' . $widthCm . 'x' . $heightCm;

        $technicalProperties['CATALOG_DIMENSIONS'] = [
            'NAME' => 'Размер (ДхШхВ), см',
            'SORT' => '999998',
            'VALUE' => $dimensionsCmString,
        ];
    }

    // Вес товара нужно добавить в конец массива технических характеристик
    if (!empty($arResult['CATALOG_WEIGHT'])) {
        $technicalProperties['CATALOG_WEIGHT'] = [
            'NAME' => 'Вес, кг',
            'SORT' => '999999',
            'VALUE' => $arResult['CATALOG_WEIGHT'] / 1000
        ];
    }
}

// Сортировка свойств по полю "SORT"
$arSortBySort = [];
$arSortByName = [];
foreach ($technicalProperties as $pKey => $arProp) {
	if (empty($arProp['VALUE']) && empty($arProp['OFFER_VALUES'])) {
		unset($technicalProperties[$pKey]);
	} else {
        $arSortBySort[$pKey] = $arProp['SORT'];
        $arSortByName[$pKey] = $arProp['NAME'];
	}
}

array_multisort($arSortBySort, SORT_ASC, $arSortByName, SORT_ASC, $technicalProperties);
?>


<article id="product-info-<?=$arResult['ID']?>" class="product" itemscope itemtype="http://schema.org/Product">
	<meta itemprop="name" content="<?=htmlspecialcharsEx($name)?>">
	<div itemprop="description" style="display: none;">
        <?if(!empty($arResult['DETAIL_TEXT'])):?>
            <?=$arResult['DETAIL_TEXT']?>
        <?else:?>
            <?=$name?>
        <?endif?>
	</div>
	<section>
		<div class="product-info">

			<div class="product-info__col product-col__slider">
                <?if(count($arResult['MORE_PHOTO'])):?>
					<div class="product-slider images main" style="display: none">
						<div class="slides-feed">
                            <?foreach($arResult['MORE_PHOTO'] as $key => $arOnePhoto):
                                $resizedImage = CFile::ResizeImageGet(
                                    $arOnePhoto['ID'],
                                    [
                                        'width' => 90,
                                        'height' => 90,
                                    ],
                                    BX_RESIZE_IMAGE_PROPORTIONAL,
                                    true
                                ); ?>
	                            <div class="slides-feed__item">
		                            <img src="<?=$resizedImage['src']?>">
	                            </div>
                            <?endforeach?>
						</div>

						<div class="big-slide">
                            <?foreach($arResult['MORE_PHOTO'] as $arOnePhoto): ?>
	                            <div class="big-slide__item">
		                            <a data-fancybox="gallery" href="<?=$arOnePhoto['SRC']?>"><img src="<?=$arOnePhoto['SRC']?>"></a>
	                            </div>
                            <?endforeach?>
						</div>
					</div>
                <?else:?>
	                <div class="product-slider images main" style="display: none">
		                <div class="slides-feed">
			                <div class="slides-feed__item">
				                <img src="/foto_not_found_90.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
			                </div>
		                </div>

		                <div class="big-slide">
			                <div class="big-slide__item">
				                <img src="/foto_not_found_510.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
			                </div>
		                </div>
	                </div>
                <?endif?>

                <?if($haveOffers):?>
	                <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):
                        $arPhotos = array();

                        if (isset($arOffer["PROPERTIES"]["MORE_PHOTO"]["VALUE"])
                            && is_array($arOffer["PROPERTIES"]["MORE_PHOTO"]["VALUE"])
                        ) {
                            foreach ($arOffer["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $FILE) {
                                $FILE = CFile::GetFileArray($FILE);

                                if (is_array($FILE)) {
                                    $arPhotos[] = $FILE;
                                }
                            }
                        }

		                if (isset($arOffer['DETAIL_PICTURE']['SRC'])) {
                            array_unshift($arPhotos, $arOffer['DETAIL_PICTURE']);
                        }
		                ?>

		                <?if(count($arPhotos)):?>
							<div class="product-slider images offer_prop_block_imgs" variant="<?=$arOffer['VARIANT'];?>">
								<div class="slides-feed">
                                    <?foreach($arPhotos as $key => $arOnePhoto):
                                        $resizedImage = CFile::ResizeImageGet(
                                            $arOnePhoto['ID'],
                                            [
                                                'width' => 90,
                                                'height' => 90,
                                            ],
                                            BX_RESIZE_IMAGE_PROPORTIONAL,
                                            true
                                        );
                                    ?>
	                                    <div class="slides-feed__item">
		                                    <img src="<?=$resizedImage['src']?>">
	                                    </div>
                                    <?endforeach?>
								</div>
								<div class="big-slide">
                                    <?foreach($arPhotos as $arOnePhoto):?>
	                                    <div class="big-slide__item">
		                                    <a data-fancybox="gallery-<?=$keyOffer?>" href="<?=$arOnePhoto['SRC']?>"><img src="<?=$arOnePhoto['SRC']?>"></a>
	                                    </div>
                                    <?endforeach?>
								</div>
							</div>
                        <?elseif (count($arResult['MORE_PHOTO'])):?>
			                <div class="product-slider images offer_prop_block_imgs" variant="<?=$arOffer['VARIANT'];?>">
				                <div class="slides-feed">
	                                <?foreach($arResult['MORE_PHOTO'] as $key => $arOnePhoto):
	                                    $resizedImage = CFile::ResizeImageGet(
	                                        $arOnePhoto['ID'],
	                                        [
	                                            'width' => 90,
	                                            'height' => 90,
	                                        ],
	                                        BX_RESIZE_IMAGE_PROPORTIONAL,
	                                        true
	                                    );
	                                    ?>
						                <div class="slides-feed__item">
							                <img src="<?=$resizedImage['src']?>">
						                </div>
	                                <?endforeach?>
				                </div>
				                <div class="big-slide">
	                                <?foreach($arResult['MORE_PHOTO'] as $arOnePhoto):?>
						                <div class="big-slide__item">
							                <a data-fancybox="gallery-<?=$keyOffer?>" href="<?=$arOnePhoto['SRC']?>"><img src="<?=$arOnePhoto['SRC']?>"></a>
						                </div>
	                                <?endforeach?>
				                </div>
			                </div>
                        <?else:?>
			                <div class="product-slider images offer_prop_block_imgs" variant="<?=$arOffer['VARIANT'];?>">
				                <div class="slides-feed">
					                <div class="slides-feed__item">
						                <img src="/foto_not_found_90.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
					                </div>
				                </div>

				                <div class="big-slide">
					                <div class="big-slide__item">
						                <img src="/foto_not_found_510.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
					                </div>
				                </div>
			                </div>
                        <?endif?>
                    <?endforeach?>
                <?endif?>
			</div>
			<div class="product-info__col product-col__data">
				<div class="product-header">
                    <?if($haveOffers):?>
                        <?
                        $offersMinPrices = [];
                        $schemaExampleOffer = false;

                        foreach ($arResult['OFFERS'] as $offer) {
                            $offersMinPrices[] = $offer['MIN_PRICE']['DISCOUNT_VALUE'];

                            if ($offer['CATALOG_QUANTITY'] > 0) {
                                $schemaExampleOffer = $offer;
                            }

                            if (!$schemaExampleOffer) {
                                $schemaExampleOffer = $arResult['OFFERS'][0];
                            }
                        }
                        ?>
						<span itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
					            <meta itemprop="lowPrice" content="<?=min($offersMinPrices)?>">
					            <meta itemprop="highPrice" content="<?=max($offersMinPrices)?>">
					            <meta itemprop="priceCurrency" content="RUB">
					            <meta itemprop="offerCount" content="<?=count($arResult['OFFERS'])?>">

					            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
									<meta itemprop="price" content="<?=$schemaExampleOffer['MIN_PRICE']['DISCOUNT_VALUE']?>">
									<meta itemprop="priceCurrency" content="RUB">

					                <?if($schemaExampleOffer['CATALOG_QUANTITY'] > 0):?>
						                <link itemprop="availability" href="http://schema.org/InStock">
                                    <?else:?>
						                <link itemprop="availability" href="http://schema.org/OutOfStock">
                                    <?endif?>
								</span>
					        </span>

                        <? $existH1 = false; ?>
                        <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):?>
                            <? if (!$existH1): ?>
								<h1 class="product-header offer_prop_block" variant="<?=$arOffer['VARIANT'];?>">
									<?=!empty($arOffer["NAME"]) ? $arOffer["NAME"] : $name?>
								</h1>
                                <? $existH1 = true; ?>
                            <? else: ?>
								<h2 class="product-header offer_prop_block" variant="<?=$arOffer['VARIANT'];?>">
									<?=!empty($arOffer["NAME"]) ? $arOffer["NAME"] : $name?>
								</h2>
                            <? endif; ?>
                        <?endforeach?>
                    <?else:?>
						<span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
				            <meta itemprop="price" content="<?=$arResult['MIN_PRICE']['DISCOUNT_VALUE']?>">
				            <meta itemprop="priceCurrency" content="RUB">

				            <?if($arResult['CATALOG_QUANTITY']):?>
					            <link itemprop="availability" href="http://schema.org/InStock">
				            <?else:?>
					            <link itemprop="availability" href="http://schema.org/OutOfStock">
				            <?endif?>
				        </span>

	                    <h1><?=$name?></h1>
                    <?endif?>
					<div class="product-share">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/share.svg" alt="">
						<div class="product-share__socials">
							<a href="https://doorlock.ru/<?=$arResult['DETAIL_PAGE_URL']?>" class="share-item js-soc-service-btn vk"><img src="<?=SITE_TEMPLATE_PATH?>/img/Vkontakte.svg" alt=""></a>
							<a href="https://doorlock.ru/<?=$arResult['DETAIL_PAGE_URL']?>" class="share-item js-soc-service-btn ok"><img src="<?=SITE_TEMPLATE_PATH?>/img/Odnoklassniki.svg" alt=""></a>
							<a href="https://doorlock.ru/<?=$arResult['DETAIL_PAGE_URL']?>" class="share-item js-soc-service-btn fb"><img src="<?=SITE_TEMPLATE_PATH?>/img/Facebook_new.svg" alt=""></a>
						</div>
					</div>
				</div>
				<div class="product-info__main">
					<div class="product-rate">
						<div class="product-rate__rating">
                            <?
                            $averageMark = floatval($arResult['PROPERTIES']['AVERAGE_MARK']['VALUE']);
                            if ($averageMark > 5) {
                                $averageMark = 5;
                            } elseif ($averageMark < 0) {
                            	$averageMark = 0;
                            }
                            ?>
							<div class="rate-item rate-stars">
								<div class="rating-stars__item <?=($averageMark >= 1)?'active-star':''?>">
									<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"/>
									</svg>
								</div>
								<div class="rating-stars__item <?=($averageMark >= 2)?'active-star':''?>">
									<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"/>
									</svg>
								</div>
								<div class="rating-stars__item <?=($averageMark >= 3)?'active-star':''?>">
									<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"/>
									</svg>
								</div>
								<div class="rating-stars__item <?=($averageMark >= 4)?'active-star':''?>">
									<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"/>
									</svg>
								</div>
								<div class="rating-stars__item <?=($averageMark >= 5)?'active-star':''?>">
									<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"/>
									</svg>
								</div>
							</div>
							<div class="rate-item rate-number">
								<?=round($averageMark, 1)?>
							</div>
							<div class="rate-item rate-comment js-leave-comment" data-product-id="<?=$arResult["ID"]?>">
								Оставить отзыв
							</div>

                            <? if ($haveOffers) {
                                foreach ($arResult['OFFERS'] as $keyOffer => $arOffer) { ?>
                                    <? if ($article = $arOffer["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]) { ?>
		                                <div class="rate-item rate-articul offer_prop_block js-catalog-detail-articul"
		                                     data-value="<?=trim($article, '*');?>"
		                                     variant="<?=$arOffer['VARIANT'];?>"
		                                     prop_art = "<?=trim($article, '*')?>">
			                                Артикул <?=trim($article, '*');?>
		                                </div>
                                    <? } ?>
                                <? } ?>
                            <?} else {?>
                                <? if ($article = $arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]) { ?>
		                            <div class="rate-item rate-articul js-catalog-detail-articul"
		                                 data-value="<?=trim($article, '*');?>">
			                            Артикул <?=trim($article, '*');?>
		                            </div>
                                <?}
                            }?>

							<div class="page-print">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="3" y="1" width="10" height="5" rx="1" stroke="#BDBDBD" stroke-width="2"/>
									<rect x="1" y="5" width="14" height="6" rx="1" fill="white" stroke="#BDBDBD" stroke-width="2"/>
									<path d="M4 8H12V14C12 14.5523 11.5523 15 11 15H5C4.44772 15 4 14.5523 4 14V8Z" fill="white" stroke="#BDBDBD" stroke-width="2"/>
									<rect x="6" y="10" width="4" height="1" rx="0.5" fill="#BDBDBD"/>
									<rect x="6" y="12" width="4" height="1" rx="0.5" fill="#BDBDBD"/>
								</svg>

								Печать
							</div>
						</div>
					</div>
                    <?if($haveOffers):?>
                        <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):?>
                            <?
                            $tagProperties = '';

                            foreach($arVariantProps as $prop) {
                                if (isset($arOffer['PROPERTIES'][$prop]) && $arOffer['PROPERTIES'][$prop]['VALUE_ENUM_ID']) {
                                    $tagProperties .= ' prop_' . $prop . '="' . $arOffer['PROPERTIES'][$prop]['VALUE_ENUM_ID'] . '"';
                                }
                            }
                            ?>
		                    <div class="product-price offer_prop_variant offer_prop_block" <?=$tagProperties?> variant="<?=$arOffer['VARIANT'];?>">
			                    <div class="item-price__current product-price__current">
				                    <?=$arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?>
			                    </div>
                                <?if($arOffer['MIN_PRICE']['DISCOUNT_DIFF'] > 0):?>
	                                <div class="item-price__old product-price__old" data-text="<?=$arOffer['MIN_PRICE']['PRINT_VALUE'];?>">
		                                <?=$arOffer['MIN_PRICE']['PRINT_VALUE'];?>

                                        <?if($arOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0):?>
			                                <div class="item-price__discount product-price__discount">
				                                -<?=$arOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];?>%
			                                </div>
                                        <?endif?>
	                                </div>
                                <?endif?>
		                    </div>
                        <?endforeach?>
                    <?else:?>
	                    <div class="product-price">
		                    <div class="item-price__current product-price__current">
                                <?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?>
		                    </div>
                            <?if($arResult['MIN_PRICE']['DISCOUNT_DIFF'] > 0):?>
			                    <div class="item-price__old product-price__old">
                                    <?=$arResult['MIN_PRICE']['PRINT_VALUE'];?>

                                    <?if($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0):?>
					                    <div class="item-price__discount product-price__discount">
						                    -<?=$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];?>%
					                    </div>
                                    <?endif?>
			                    </div>
                            <?endif?>
	                    </div>
                    <?endif?>

                    <?if ($haveOffers):?>
                        <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):?>
		                    <div class="product-status offer_prop_block_amount"
		                         prod_id="<?=$arOffer['ID']?>"
		                         variant="<?=$arOffer['VARIANT'];?>"
		                         quant="<?=$arOffer['CATALOG_QUANTITY']?>">
			                    <div class="product-status__check">
                                    <span class="status-check__icon">
	                                    <?if($arOffer['CATALOG_QUANTITY'] > 0):?>
		                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/status-done.svg" alt="">
	                                    <?else:?>
		                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/status-done.svg" alt="">
	                                    <?endif?>
                                    </span>
				                    <?=($arOffer['CATALOG_QUANTITY'] > 0)?'Есть':'Нет'?> на складе
			                    </div>
			                    <div class="product-status__opt js-load-web-form-pop-up"
			                         data-web_form_text_id="wholesale_prices"
			                         data-prod_href="<?=$arResult['DETAIL_PAGE_URL']?>">
				                    Получить оптовые цены
				                    <span class="status-opt__icon">
                                        <img src="<?=SITE_TEMPLATE_PATH?>/img/tooltip.svg" alt="">
                                        <span class="tooltip">
                                            Форма запроса на оптовые цены
                                        </span>
                                    </span>
			                    </div>
		                    </div>
                        <?endforeach?>
                    <?else:?>
	                    <div class="product-status"
	                         quant="<?=$arResult['CATALOG_QUANTITY']?>">
		                    <div class="product-status__check">
                                    <span class="status-check__icon">
	                                    <?if($arResult['CATALOG_QUANTITY'] > 0):?>
		                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/status-done.svg" alt="">
                                        <?else:?>
		                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/status-done.svg" alt="">
                                        <?endif?>
                                    </span>
                                <?=($arResult['CATALOG_QUANTITY'] > 0)?'Есть':'Нет'?> на складе
		                    </div>
		                    <div class="product-status__opt js-load-web-form-pop-up"
		                         data-web_form_text_id="wholesale_prices"
		                         data-prod_href="<?=$arResult['DETAIL_PAGE_URL']?>">
			                    Получить оптовые цены
			                    <span class="status-opt__icon">
                                        <img src="<?=SITE_TEMPLATE_PATH?>/img/tooltip.svg" alt="">
                                        <span class="tooltip">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, id!
                                        </span>
                                    </span>
		                    </div>
	                    </div>
                    <?endif?>

					<div class="product-setup">
                        <?if($haveOffers):?>
                            <?	if (isset($arOffersProps['COLOR']["VALUES"]) && count($arOffersProps['COLOR']["VALUES"])):
                                $arColors = array();
                                foreach($arOffersProps['COLOR']["VALUES"] as $arColor) {
                                    while (isset($arColors[$arColor['SORT']])) ++$arColor['SORT'];
                                    $arColors[$arColor['SORT']] = $arColor;
                                }
                                ksort($arColors);
                                ?>
		                        <div class="setup-color color">
			                        <div class="product-setup__header">
                                        <?=$arOffersProps['COLOR']['NAME']?>
			                        </div>
			                        <div class="features">
                                        <? foreach($arColors as $arColor) { ?>
	                                        <div class="form_radio_btn">
		                                        <input type="radio" class="prop_input"
		                                               name="COLOR"
		                                               prop="COLOR:<?=$arColor['VALUE_ENUM_ID'];?>"
		                                               prop_id="<?=$arColor['VALUE_ENUM_ID'];?>"
		                                               id="<?=$arResult['ID']?>_product_color_check<?=$arColor['SORT'];?>"
		                                               value="<?=$arColor['NAME'];?>">
		                                        <label class="radio-color-label" for="<?=$arResult['ID']?>_product_color_check<?=$arColor['SORT'];?>">
			                                        <div class="color-item silver" style="background-image: url(<?=$arColor['VALUE'];?>);"></div>
			                                        <span class="color-hint">
	                                                    <?=$arColor['NAME'];?>
                                                    </span>
		                                        </label>
	                                        </div>
                                        <? } ?>
			                        </div>
		                        </div>
                                <?
                            endif; ?>
                        <?endif?>

                        <?foreach($arOffersProps as $key => $arOffersProp):?>
                            <?
                            if (in_array($key,['COLOR', 'FACTORY_ITEM']))
                                continue;

                            $arProp = array();

                            foreach ($arOffersProp["VALUES"] as $arOffersPropValues) {
                                while (isset($arProp[$arOffersPropValues['SORT']])) {
                                    ++$arOffersPropValues['SORT'];
                                }

                                $arProp[$arOffersPropValues['SORT']] = $arOffersPropValues;
                            }

                            ksort($arProp);
                            ?>
	                        <div class="setup-<?=$key?> options">
		                        <div class="product-setup__header">
                                    <?=$arOffersProp['NAME'];?>
		                        </div>
		                        <div class="features">
                                    <?foreach($arProp as $arPropValues):?>
	                                    <div class="form_radio_btn">
		                                    <input type="radio" class="prop_input"
		                                           name="<?=$key;?>"
		                                           prop="<?=$key;?>:<?=$arPropValues['VALUE_ENUM_ID'];?>"
		                                           prop_id="<?=$arPropValues['VALUE_ENUM_ID'];?>"
		                                           id="<?=$arResult['ID']?>_<?=$key;?>_<?=$arPropValues['SORT']?>"
		                                           value="<?=$arPropValues['VALUE'];?>">
		                                    <label for="<?=$arResult['ID']?>_<?=$key;?>_<?=$arPropValues['SORT']?>"><?=$arPropValues['VALUE']?></label>
	                                    </div>
                                    <?endforeach?>
		                        </div>
	                        </div>
                        <?endforeach?>
					</div>

					<?if ($haveOffers):?>
                        <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):
                            $resizedSmallImage = CFile::ResizeImageGet(
                                $arOnePhoto['ID'],
                                [
                                    'width' => 290,
                                    'height' => 290,
                                ],
                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                true
                            );

                            if (empty($resizedSmallImage)) {
                                $resizedSmallImage = '/foto_not_found_290.jpg';
                            } else {
                                $resizedSmallImage = $resizedSmallImage['src'];
                            }
							?>
							<div class="product-btns buy offers_buy_block offer_prop_block"
							     prod_id="<?=$arOffer['ID']?>"
							     variant="<?=$arOffer['VARIANT'];?>">
                                <? if($arOffer['CATALOG_AVAILABLE'] != "Y" || empty($arOffer['CATALOG_QUANTITY'])): ?>
                                <?php else: ?>
									<div class="product-btns__row">
										<div class="counter-wrap">
		                                    <div class="item-counter">
			                                    <span class="item-counter__minus counter-limit"></span>
			                                    <input type="text" class="item-counter__number js-product-quantity" value="1" data-min="1">
			                                    <span class="item-counter__plus <?= ($arOffer["AVAILABLE_QUANTITY"] == 1) ? 'counter-limit' : '' ?>"></span>
		                                    </div>
											<div class="goods-remains <?= ($arOffer["AVAILABLE_QUANTITY"] == 1) ? '' : 'goods-remains-hidden' ?>">Доступно <?=$arOffer['CATALOG_QUANTITY']?> шт.</div>
										</div>

	                                    <div class="item-buy__btn product-btn js_add_to_cart js_product_page"
	                                         data-img="<?=$resizedSmallImage?>"
	                                         data-title="<?= $arResult["NAME"]; ?>">Купить</div>
									</div>
                                <?php endif; ?>

								<div class="product-btns__row">
                                    <?if($arOffer['CATALOG_AVAILABLE'] != "Y" || empty($arOffer['CATALOG_QUANTITY'])): ?>
	                                    <div class="item-buy__btn product-btn js-item-subscribe-item"
	                                         data-item_id="<?=$arOffer['ID']?>"
	                                         data-text_off="Уведомить о поступлении"
	                                         data-text_on="Отписаться от уведомлений"
	                                         style="width: 220px;">Уведомить о поступлении</div>
                                    <?php else: ?>
										<div class="item-buy__click product-btn quick_buy_product_card js-load-web-form-pop-up"
										     data-web_form_text_id="buy_one_click"
										     data-prod_href="<?=$arResult['DETAIL_PAGE_URL']?>">Купить в 1 клик</div>
                                    <?php endif; ?>
									<div class="to-fav-btns">
										<span class="fav-comp js-item-compare"
										      data-product_id="<?=$arResult['ID']?>" data-iblock="<?=$arResult['IBLOCK_ID']?>">
											<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="6" y="14" width="8" height="12" rx="3" stroke="#1F3664" stroke-width="2"/>
                                                <rect x="18" y="6" width="8" height="20" rx="3" stroke="#1F3664" stroke-width="2"/>
                                            </svg>
										</span>
										<span class="js-item-favourites fav-heart" data-product_id="<?=$arResult['ID']?>">
								            <svg width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									            <path d="M11.281 4.10271L12 4.84663L12.719 4.10271L14.2099 2.56023C16.2206 0.479926 19.4951 0.479927 21.5058 2.56023C23.4981 4.62143 23.4981 7.94965 21.5058 10.0108L12 19.8458L2.49417 10.0108C0.501943 7.94964 0.501944 4.62142 2.49417 2.56023C4.50487 0.479923 7.77941 0.479925 9.7901 2.56023L11.281 4.10271Z" stroke="#1F3664" stroke-width="2"/>
								            </svg>
										</span>
									</div>
								</div>
							</div>
                        <?endforeach?>
                    <?else:?>
						<div class="product-btns buy offers_buy_block">
							<div class="product-btns__row">
								<div class="item-counter">
									<span class="item-counter__minus"></span>
									<input type="text" class="item-counter__number js-product-quantity" value="1" data-min="1">
									<span class="item-counter__plus"></span>
								</div>
								<div class="item-buy__btn product-btn js_add_to_cart js_product_page">Купить</div>
							</div>

							<div class="product-btns__row">
								<div class="item-buy__click product-btn quick_buy_product_card js-load-web-form-pop-up"
								     data-web_form_text_id="buy_one_click"
								     data-prod_href="<?=$arResult['DETAIL_PAGE_URL']?>">Купить в 1 клик</div>
								<div class="to-fav-btns">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/compare.svg" alt="">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/like.svg" alt="">
								</div>
							</div>
						</div>
                    <?endif?>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="char-doc">
            <?if(!empty($technicalProperties)):
	            $arTechnicalPropsChunk = array_chunk($technicalProperties, round(count($technicalProperties)/2));
	            ?>
				<div class="characteristics">
					<div class="section-header">
						Технические характеристики
					</div>
					<div class="chars-row">
						<? foreach ($arTechnicalPropsChunk as $arChunk): ?>
							<div class="chars-col">
                                <?foreach($arChunk as $property):?>
                                    <?if(!empty($property['OFFER_VALUES'])):?>
                                        <?foreach($property['OFFER_VALUES'] as $variant => $value):?>
                                            <?if($value != ''):?>
				                                <div class="chars-col__row offer_prop_block" variant="<?=$variant?>">
					                                <div class="chars-props"><?=$property["NAME"];?></div>
					                                <div class="chars-value"><?=$value?></div>
				                                </div>
                                            <?endif?>
                                        <?endforeach?>
                                    <?elseif($property["VALUE"] != ''):?>
		                                <div class="chars-col__row">
			                                <div class="chars-props"><?=$property["NAME"];?></div>
			                                <div class="chars-value">
                                                <?if($property['CODE'] == "RELIABILITY"):?>
                                                    <?$reliability = intval($property["VALUE"])?>

                                                    <? if ($reliability > 0 && $reliability <= 5): ?>
		                                                <div class="rate-item rate-stars">
			                                                <div class="rating-stars__item <?=($reliability>=1) ? 'active-star' : ''?>">
				                                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					                                                <path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
				                                                </svg>
			                                                </div>
			                                                <div class="rating-stars__item <?=($reliability>=2) ? 'active-star' : ''?>">
				                                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					                                                <path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
				                                                </svg>
			                                                </div>
			                                                <div class="rating-stars__item <?=($reliability>=3) ? 'active-star' : ''?>">
				                                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					                                                <path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
				                                                </svg>
			                                                </div>
			                                                <div class="rating-stars__item <?=($reliability>=4) ? 'active-star' : ''?>">
				                                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					                                                <path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
				                                                </svg>
			                                                </div>
			                                                <div class="rating-stars__item <?=($reliability>=5) ? 'active-star' : ''?>">
				                                                <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					                                                <path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
				                                                </svg>
			                                                </div>
		                                                </div>
                                                    <?endif?>
                                                <?elseif($property['CODE'] == "BREND" && isset($arBrend)):?>
                                                    <?=$arBrend["NAME"]?>
                                                <?else:?>
                                                    <?=$property["VALUE"]?>
                                                <?endif?>
			                                </div>
		                                </div>
                                    <?endif?>
                                <?endforeach?>
							</div>
						<?endforeach;?>
					</div>
				</div>
			<?endif;?>

			<?if (is_array($arResult['PROPERTIES']['DOWNLOAD']['VALUE']) && count($arResult['PROPERTIES']['DOWNLOAD']['VALUE'])):
		        $arText = explode("|", $arResult['PROPERTIES']['DOWNLOAD_TEXT']['VALUE']);?>
				<div class="documents">
					<div class="section-header">
						Документы
					</div>
					<div class="docs-col">
				        <? foreach ($arResult['PROPERTIES']['DOWNLOAD']['VALUE'] as $key => $arFile):
                            if ($path = CFile::GetPath($arFile)):
                                $fileName = preg_replace('/\.\w+$/', '', CFile::GetFileArray($arFile)["ORIGINAL_NAME"]);
                                $text = '';
                                if (isset($arText[$key]) && $arText[$key]) {
                                    $text = $arText[$key];
                                } else {
                                    $text = $fileName;
                                }

				                $temp = explode(".", $path);
				                if ($temp[count($temp) - 1] == "pdf"): ?>
					                <div class="docs-item">
						                <img src="<?=SITE_TEMPLATE_PATH?>/img/pdf-icon.svg">
						                <a href="<?=$path?>"><?=$text?></a>
					                </div>
				                <? elseif ($temp[count($temp) - 1] == "mp4"): ?>
					                <div class="docs-item">
						                <img src="<?=SITE_TEMPLATE_PATH?>/img/lk/order.svg">
						                <a href="<?=$path?>" target="_blank"><?=$text?></a>
					                </div>
				                <? elseif ($temp[count($temp) - 1] == "dwg"):
				                    $path = '/download_file.php?element_id=' . $arResult['ID'] . '&file_id=' . $arFile . '&iblock_id=' . CATALOG_IBLOCK_ID . '&property_id=' . $arResult['PROPERTIES']['DOWNLOAD']['ID'] . '&type=iblock_property_file';
				                ?>
					                <div class="docs-item">
						                <img src="<?=SITE_TEMPLATE_PATH?>/img/lk/order.svg">
						                <a href="<?=$path?>" target="_blank"><?=$text?></a>
					                </div>
				                <? else:
				                    /*$tab_d .= '<a href="' . $path . '" class="item fancy_img" data-fancybox="certs">
				                            <img src="' . $path . '" alt="" />
				                            ' . $text . '
				                        </a>';*/
				                endif;
				            endif;
				        endforeach; ?>
					</div>
				</div>
		    <? endif; ?>
		</div>
	</section>

    <?if(!empty($arResult['DETAIL_TEXT'])):?>
		<section>
			<div class="section-header">
				Описание
			</div>
			<div class="description">
	            <?=$arResult['DETAIL_TEXT']?>
			</div>
		</section>
    <?endif?>

	<section id="marks-list" data-product-id="<?=$arResult['ID']?>">

	</section>

	<?php
	// С данным товаром необходимо приобрести
	$arRelatedProductIds = $arRelatedOfferIds = [];

	$productOffersRelations = [];

    if (!empty($arResult['OFFERS'])) {
        foreach ($arResult['OFFERS'] as $offer) {
            if (!isset($productOffersRelations[$offer['ID']])) {
                $productOffersRelations[$offer['ID']] = [
                    'variant' => $offer['VARIANT'],
                    'product_ids' => [],
                    'offer_ids' => [],
                ];
            }

            if (!empty($offer['PROPERTIES']['WITH_THIS_PRODUCT_YOU_NEED_TO_PURCHASE']['VALUE'])) {
                foreach ($offer['PROPERTIES']['WITH_THIS_PRODUCT_YOU_NEED_TO_PURCHASE']['VALUE'] as $id) {
                    $productOffersRelations[$offer['ID']]['offer_ids'][$id] = $id;
                }
            }
        }
    }


    if (!empty($arResult['OFFERS'])) {
        $filterOfferIds = array_map(function ($item) {
            return $item['ID'];
        }, $arResult['OFFERS']);

        if (!empty($filterOfferIds)) {
            $productRelationsInverseObj = CIBlockElement::GetList(
                [],
                [
                    "IBLOCK_ID" => OFFERS_IBLOCK_ID,
                    "=PROPERTY_WITH_THIS_PRODUCT_YOU_NEED_TO_PURCHASE" => $filterOfferIds,
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y"
                ],
                false,
                false,
                [
                    'ID',
                    'IBLOCK_ID',
                    'PROPERTY_WITH_THIS_PRODUCT_YOU_NEED_TO_PURCHASE',
                ]
            );

            while ($productRelationsInverseAr = $productRelationsInverseObj->GetNext(false, false)) {
                $id = $productRelationsInverseAr['ID'];
                $relOfferId = $productRelationsInverseAr['PROPERTY_WITH_THIS_PRODUCT_YOU_NEED_TO_PURCHASE_VALUE'];

                $productOffersRelations[$relOfferId]['offer_ids'][$id] = $id;
            }
        }
    }

    if (!empty($arRelatedOfferIds) || !empty($arRelatedProductIds)) {
        if (empty($productOffersRelations)) {
            // У товара нет торговых предложений - блок с сопутствующими товарами один на страницу
            $productOffersRelations[] = [
                'product_ids' => $arRelatedProductIds,
                'offer_ids' => $arRelatedOfferIds,
            ];
        } else {
            // Дополняем данные по каждому торговому предложению общими данными по товару
            foreach ($productOffersRelations as $offerId => $relations) {
                if (empty($relations)) {
                    $productOffersRelations[$offerId]['product_ids'] = $arRelatedProductIds;
                    $productOffersRelations[$offerId]['offer_ids'] = $arRelatedOfferIds;
                } else {
                    $productOffersRelations[$offerId]['product_ids'] = array_merge($productOffersRelations[$offerId]['product_ids'],
                        $arRelatedProductIds);
                    $productOffersRelations[$offerId]['offer_ids'] = array_merge((!empty($productOffersRelations[$offerId]['offer_ids'])) ? $productOffersRelations[$offerId]['offer_ids'] : [],
                        $arRelatedOfferIds);
                }
            }
        }
        // Дополняем данные по каждому торговому предложению общими данными по товару
        foreach ($productOffersRelations as $offerId => $relations) {
            $productOffersRelations[$offerId]['offer_ids'] = array_merge($productOffersRelations[$offerId]['offer_ids'],
                $arRelatedOfferIds);
        }
    } ?>


    <? if (!empty($productOffersRelations)): ?>
    <? foreach ($productOffersRelations

    as $relations):
    // --- Фильтрация элементов ---
    global $productRelatedFilter;

    if (!empty($relations['offer_ids'])) {
        $productRelatedFilter = [
            [
                "LOGIC" => "OR",
                ["=ID" => array_merge($relations['product_ids'], $relations['offer_ids'])],
                [
                    "=ID" => CIBlockElement::SubQuery(
                        "PROPERTY_CML2_LINK",
                        [
                            "IBLOCK_ID" => OFFERS_IBLOCK_ID,
                            "=ID" => $relations['offer_ids']
                        ]
                    )
                ]
            ]
        ];
    } else {
        if (!empty($relations['product_ids'])) {
            $productRelatedFilter = ['=ID' => $relations['product_ids']];
        } else {
            continue;
        }
    }
    // ----------------------------
    ?>

    <? if (!empty($relations['variant'])): ?>
	<section class="related offer_prop_block" variant="<?= $relations['variant'] ?>">
        <? else: ?>
		<section class="related">
            <? endif ?>
            <?
            $APPLICATION->IncludeComponent(
                "custom:catalog.iblocks.section",
                "slider",
                [
                    "IBLOCK_TYPE" => 'cat',
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                    "IBLOCK_IDS" => [CATALOG_IBLOCK_ID, OFFERS_IBLOCK_ID],
                    "CUSTOM_TITLE" => [
                        'name' => 'С данным товаром необходимо приобрести'
                    ],
                    "SECTION_ID" => "0",
                    "SECTION_CODE" => "",
                    "SECTION_USER_FIELDS" => [
                        0 => "",
                    ],
                    "ELEMENT_SORT_FIELD" => 'rank',
                    "ELEMENT_SORT_ORDER" => 'desc',
                    "ELEMENT_SORT_FIELD2" => 'shows',
                    "ELEMENT_SORT_ORDER2" => 'desc',
                    "FILTER_NAME" => "productRelatedFilter",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "PAGE_ELEMENT_COUNT" => "1000",
                    "PROPERTY_CODE" => [
                        0 => "CML2_ARTICLE"
                    ],
                    "OFFERS_LIMIT" => "0",
                    "TEMPLATE_THEME" => "blue",
                    "ADD_PICT_PROP" => "-",
                    "LABEL_PROP" => "-",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "Y",
                    "SHOW_OLD_PRICE" => "Y",
                    "SHOW_CLOSE_POPUP" => "N",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SEF_MODE" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SET_TITLE" => "Y",
                    "SET_BROWSER_TITLE" => "Y",
                    "BROWSER_TITLE" => "-",
                    "SET_META_KEYWORDS" => "Y",
                    "META_KEYWORDS" => "-",
                    "SET_META_DESCRIPTION" => "Y",
                    "META_DESCRIPTION" => "-",
                    "SET_LAST_MODIFIED" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "N",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRICE_CODE" => getUserPriceGroup($USER),
                    "USE_PRICE_COUNT" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "CONVERT_CURRENCY" => "Y",
                    "BASKET_URL" => "/personal/cart/",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "PRODUCT_QUANTITY_VARIABLE" => "",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "Y",
                    "PRODUCT_PROPERTIES" => [],
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "OFFERS_FIELD_CODE" => [
                        0 => "",
                    ],
                    "OFFERS_PROPERTY_CODE" => [
                        0 => "CML2_ATTRIBUTES",
                    ],
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "OFFERS_CART_PROPERTIES" => [],
                    "CURRENCY_ID" => "RUB"
                ],
                false
            );
            ?>
		</section>
        <? endforeach ?>
        <? endif ?>



    <?
    // Сопутствующие товары и торговые предложения у товара
    $arRelatedProductIds = $arRelatedOfferIds = [];

    if (!empty($arResult['PROPERTIES']['RELATED_PRODS']['VALUE'])) {
        foreach ($arResult['PROPERTIES']['RELATED_PRODS']['VALUE'] as $id) {
            $arRelatedProductIds[$id] = $id;
        }
    }

    if (!empty($arResult['PROPERTIES']['RELATED_OFFERS']['VALUE'])) {
        foreach ($arResult['PROPERTIES']['RELATED_OFFERS']['VALUE'] as $id) {
            $arRelatedOfferIds[$id] = $id;
        }
    }

    // Получаем товары и торговые предложения, у которых текущий товар указан как сопутствующий
    $productRelationsInverseObj = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID" => [CATALOG_IBLOCK_ID, OFFERS_IBLOCK_ID],
            "PROPERTY_RELATED_PRODS" => $arResult['ID'],
            "ACTIVE_DATE" => "Y",
            "ACTIVE" => "Y"
        ],
        false,
        false,
        [
            'ID',
            'IBLOCK_ID'
        ]
    );

    while ($productRelationsInverseAr = $productRelationsInverseObj->GetNext()) {
        $id = $productRelationsInverseAr['ID'];

        if ($productRelationsInverseAr['IBLOCK_ID'] == CATALOG_IBLOCK_ID) {
            $arRelatedProductIds[$id] = $id;
        } else {
            $arRelatedOfferIds[$id] = $id;
        }
    }

    $productOffersRelations = [];

    if (!empty($arResult['OFFERS'])) {
        foreach ($arResult['OFFERS'] as $offer) {
            if (!isset($productOffersRelations[$offer['ID']])) {
                $productOffersRelations[$offer['ID']] = [
                    'variant' => $offer['VARIANT'],
                    'product_ids' => [],
                    'offer_ids' => []
                ];
            }

            // Собираем сопутствующие товары и торговые предложения этого предложения
            if (!empty($offer['PROPERTIES']['RELATED_PRODS']['VALUE'])) {
                foreach ($offer['PROPERTIES']['RELATED_PRODS']['VALUE'] as $id) {
                    $productOffersRelations[$offer['ID']]['product_ids'][$id] = $id;
                }
            }

            if (!empty($offer['PROPERTIES']['RELATED_OFFERS']['VALUE'])) {
                foreach ($offer['PROPERTIES']['RELATED_OFFERS']['VALUE'] as $id) {
                    $productOffersRelations[$offer['ID']]['offer_ids'][$id] = $id;
                }
            }

            // Собираем товары и торговые предложения, у которых текущее предложение указано в сопутствующих
            $offerRelationsInverseObj = CIBlockElement::GetList(
                [],
                [
                    "IBLOCK_ID" => [CATALOG_IBLOCK_ID, OFFERS_IBLOCK_ID],
                    "PROPERTY_RELATED_OFFERS" => $offer['ID'],
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y"
                ],
                false,
                false,
                [
                    'ID',
                    'IBLOCK_ID'
                ]
            );

            while ($offerRelationsInverseAr = $offerRelationsInverseObj->GetNext()) {
                $id = $offerRelationsInverseAr['ID'];

                if ($offerRelationsInverseAr['IBLOCK_ID'] == CATALOG_IBLOCK_ID) {
                    $productOffersRelations[$offer['ID']]['product_ids'][$id] = $id;
                } else {
                    $productOffersRelations[$offer['ID']]['offer_ids'][$id] = $id;
                }
            }
        }
    }

    if (!empty($arRelatedProductIds) || !empty($arRelatedOfferIds)) {
        if (empty($productOffersRelations)) {
            // У товара нет торговых предложений - блок с сопутствующими товарами один на страницу
            $productOffersRelations[] = [
                'product_ids' => $arRelatedProductIds,
                'offer_ids' => $arRelatedOfferIds,
            ];
        } else {
            // Дополняем данные по каждому торговому предложению общими данными по товару
            foreach ($productOffersRelations as $offerId => $relations) {
                if (empty($relations)) {
                    $productOffersRelations[$offerId]['product_ids'] = $arRelatedProductIds;
                    $productOffersRelations[$offerId]['offer_ids'] = $arRelatedOfferIds;
                } else {
                    $productOffersRelations[$offerId]['product_ids'] = array_merge($productOffersRelations[$offerId]['product_ids'], $arRelatedProductIds);
                    $productOffersRelations[$offerId]['offer_ids'] = array_merge($productOffersRelations[$offerId]['offer_ids'], $arRelatedOfferIds);
                }
            }
        }
    }
    ?>

    <?if(!empty($productOffersRelations)):?>
	    <?foreach($productOffersRelations as $relations):
		    // --- Фильтрация элементов ---
		    global $productRelatedFilter;

		    if (!empty($relations['offer_ids'])) {
                $productRelatedFilter = [
                    [
                        "LOGIC" => "OR",
                        ["=ID" => array_merge($relations['product_ids'], $relations['offer_ids'])],
                        [
                            "=ID" => CIBlockElement::SubQuery(
                                "PROPERTY_CML2_LINK",
                                [
                                    "IBLOCK_ID" => OFFERS_IBLOCK_ID,
                                    "=ID" => $relations['offer_ids']
                                ]
                            )
                        ]
                    ]
                ];
            } else if (!empty($relations['product_ids'])) {
		        $productRelatedFilter = ['=ID' => $relations['product_ids']];
		    } else {
		        continue;
		    }
		    // ----------------------------
		    ?>

		    <?if(!empty($relations['variant'])):?>
				<section class="related offer_prop_block" variant="<?=$relations['variant']?>">
	        <?else:?>
				<section class="related">
	        <?endif?>
	            <?
	            $APPLICATION->IncludeComponent(
	                "custom:catalog.iblocks.section",
	                "slider",
	                array(
	                    "IBLOCK_TYPE" => 'cat',
	                    "IBLOCK_ID" => CATALOG_IBLOCK_ID,
	                    "IBLOCK_IDS" => [CATALOG_IBLOCK_ID, OFFERS_IBLOCK_ID],
	                    "CUSTOM_TITLE" => [
                            'name' => 'Сопутствующие товары'
	                    ],
	                    "SECTION_ID" => "0",
	                    "SECTION_CODE" => "",
	                    "SECTION_USER_FIELDS" => array(
	                        0 => "",
	                    ),
	                    "ELEMENT_SORT_FIELD" => 'rank',
	                    "ELEMENT_SORT_ORDER" => 'desc',
	                    "ELEMENT_SORT_FIELD2" => 'shows',
	                    "ELEMENT_SORT_ORDER2" => 'desc',
	                    "FILTER_NAME" => "productRelatedFilter",
	                    "INCLUDE_SUBSECTIONS" => "Y",
	                    "SHOW_ALL_WO_SECTION" => "Y",
	                    "HIDE_NOT_AVAILABLE" => "N",
	                    "PAGE_ELEMENT_COUNT" => "1000",
	                    "PROPERTY_CODE" => array(
	                        0 => "CML2_ARTICLE"
	                    ),
	                    "OFFERS_LIMIT" => "0",
	                    "TEMPLATE_THEME" => "blue",
	                    "ADD_PICT_PROP" => "-",
	                    "LABEL_PROP" => "-",
	                    "PRODUCT_SUBSCRIPTION" => "N",
	                    "SHOW_DISCOUNT_PERCENT" => "Y",
	                    "SHOW_OLD_PRICE" => "Y",
	                    "SHOW_CLOSE_POPUP" => "N",
	                    "MESS_BTN_BUY" => "Купить",
	                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
	                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
	                    "MESS_BTN_DETAIL" => "Подробнее",
	                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
	                    "SECTION_URL" => "",
	                    "DETAIL_URL" => "",
	                    "SECTION_ID_VARIABLE" => "SECTION_ID",
	                    "SEF_MODE" => "N",
	                    "AJAX_MODE" => "N",
	                    "AJAX_OPTION_JUMP" => "N",
	                    "AJAX_OPTION_STYLE" => "Y",
	                    "AJAX_OPTION_HISTORY" => "N",
	                    "AJAX_OPTION_ADDITIONAL" => "",
	                    "CACHE_TYPE" => "A",
	                    "CACHE_TIME" => "36000000",
	                    "CACHE_GROUPS" => "Y",
	                    "SET_TITLE" => "Y",
	                    "SET_BROWSER_TITLE" => "Y",
	                    "BROWSER_TITLE" => "-",
	                    "SET_META_KEYWORDS" => "Y",
	                    "META_KEYWORDS" => "-",
	                    "SET_META_DESCRIPTION" => "Y",
	                    "META_DESCRIPTION" => "-",
	                    "SET_LAST_MODIFIED" => "N",
	                    "USE_MAIN_ELEMENT_SECTION" => "N",
	                    "ADD_SECTIONS_CHAIN" => "N",
	                    "CACHE_FILTER" => "N",
	                    "ACTION_VARIABLE" => "action",
	                    "PRODUCT_ID_VARIABLE" => "id",
	                    "PRICE_CODE" => getUserPriceGroup($USER),
	                    "USE_PRICE_COUNT" => "N",
	                    "SHOW_PRICE_COUNT" => "1",
	                    "PRICE_VAT_INCLUDE" => "Y",
	                    "CONVERT_CURRENCY" => "Y",
	                    "BASKET_URL" => "/personal/cart/",
	                    "USE_PRODUCT_QUANTITY" => "N",
	                    "PRODUCT_QUANTITY_VARIABLE" => "",
	                    "ADD_PROPERTIES_TO_BASKET" => "Y",
	                    "PRODUCT_PROPS_VARIABLE" => "prop",
	                    "PARTIAL_PRODUCT_PROPERTIES" => "Y",
	                    "PRODUCT_PROPERTIES" => array(),
	                    "ADD_TO_BASKET_ACTION" => "ADD",
	                    "PAGER_TEMPLATE" => ".default",
	                    "DISPLAY_TOP_PAGER" => "N",
	                    "DISPLAY_BOTTOM_PAGER" => "N",
	                    "PAGER_TITLE" => "Товары",
	                    "PAGER_SHOW_ALWAYS" => "N",
	                    "PAGER_DESC_NUMBERING" => "N",
	                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	                    "PAGER_SHOW_ALL" => "N",
	                    "PAGER_BASE_LINK_ENABLE" => "N",
	                    "SET_STATUS_404" => "N",
	                    "SHOW_404" => "N",
	                    "MESSAGE_404" => "",
	                    "OFFERS_FIELD_CODE" => array(
	                        0 => "",
	                    ),
	                    "OFFERS_PROPERTY_CODE" => array(
	                        0 => "CML2_ATTRIBUTES",
	                    ),
	                    "OFFERS_SORT_FIELD" => "sort",
	                    "OFFERS_SORT_ORDER" => "asc",
	                    "OFFERS_SORT_FIELD2" => "id",
	                    "OFFERS_SORT_ORDER2" => "desc",
	                    "PRODUCT_DISPLAY_MODE" => "N",
	                    "OFFERS_CART_PROPERTIES" => array(),
	                    "CURRENCY_ID" => "RUB"
	                ),
	                false
	            );
	            ?>
			</section>
        <?endforeach?>
    <?endif?>
</article>

<div class="product-print">
	<div class="page-print-content">
		<div class="product-header"></div>
		<div class="product-rate__rating">
			<div class="rate-item rate-articul"></div>
			<div class="product-price">
				<div class="item-price__current product-price__current"></div>
				<div class="item-price__old product-price__old"></div>
			</div>
		</div>

		<div class="product-print-img">
			<div class="print-img__main">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/card-slide-img.png">
			</div>
			<div class="print-img__secondary">
				<div class="print-img__secondary-item first">
					<img src="<?=SITE_TEMPLATE_PATH?>/img/card-slide-img.png" alt="">
				</div>
				<div class="print-img__secondary-item second">
					<img src="<?=SITE_TEMPLATE_PATH?>/img/card-slide-img.png" alt="">
				</div>
			</div>
		</div>
		<div class="characteristics"></div>
	</div>

	<div class="print-card-description">
		<div class="section-header">
			Описание
		</div>
		<div class="description">

		</div>
	</div>
</div>


<script>
    initCatalogDetail('<?='#product-info-' . $arResult['ID']?>');
</script>