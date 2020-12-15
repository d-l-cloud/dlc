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
        if (!empty($arOffer['CATALOG_WIDTH']) && !empty($offer['CATALOG_LENGTH']) && !empty($offer['CATALOG_HEIGHT'])) {
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
    $arSortBySort[$pKey] = $arProp['SORT'];
    $arSortByName[$pKey] = $arProp['NAME'];
}

array_multisort($arSortBySort, SORT_ASC, $arSortByName, SORT_ASC, $technicalProperties);
?>

<div class="fast-review">
	<div id="product-info-<?=$arResult['ID']?>" class="product-info fast-review__info">
		<div class="product-info__col product-review__left">
            <?if($haveOffers):?>
	            <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):?>
                    <?if($arOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0):?>
			            <div class="item-price__discount product-price__discount fast-review__discount offer_prop_block"
			                 variant="<?=$arOffer['VARIANT'];?>">
				            -<?=$arOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];?>%
			            </div>
                    <?endif?>
                <?endforeach;?>
            <?else:?>
                <?if($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0):?>
		            <div class="item-price__discount product-price__discount fast-review__discount">
			            -<?=$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];?>%
		            </div>
                <?endif?>
            <?endif?>
			<div class="product-share">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/share.svg" alt="">
				<div class="product-share__socials">
					<a href="https://doorlock.ru/<?=$arResult['DETAIL_PAGE_URL']?>" class="share-item js-soc-service-btn vk"><img src="<?=SITE_TEMPLATE_PATH?>/img/Vkontakte.svg" alt=""></a>
					<a href="https://doorlock.ru/<?=$arResult['DETAIL_PAGE_URL']?>" class="share-item js-soc-service-btn ok"><img src="<?=SITE_TEMPLATE_PATH?>/img/Odnoklassniki.svg" alt=""></a>
					<a href="https://doorlock.ru/<?=$arResult['DETAIL_PAGE_URL']?>" class="share-item js-soc-service-btn fb"><img src="<?=SITE_TEMPLATE_PATH?>/img/Facebook_new.svg" alt=""></a>
				</div>
			</div>
            <?if(count($arResult['MORE_PHOTO'])):?>
				<div class="fast-review__slider images main" style="display: none">
					<div class="review-slide__main">
                        <?foreach($arResult['MORE_PHOTO'] as $arOnePhoto):?>
							<div class="slide-main__item">
								<img src="<?=$arOnePhoto['SRC']?>">
							</div>
                        <?endforeach?>
					</div>

					<div class="review-slide__thumbnail">
                        <?foreach($arResult['MORE_PHOTO'] as $key => $arOnePhoto):
                            $resizedImage = CFile::ResizeImageGet(
                                $arOnePhoto['ID'],
                                [
                                    'width' => 80,
                                    'height' => 80,
                                ],
                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                true
                            ); ?>
							<div class="slide-thumbnail__item">
								<img src="<?=$resizedImage['src']?>">
							</div>
                        <?endforeach?>
					</div>
				</div>
            <?else:?>
	            <div class="fast-review__slider images main" style="display: none">
		            <div class="review-slide__main">
			            <div class="slide-main__item">
				            <img src="/foto_not_found_510.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
			            </div>
		            </div>
		            <div class="review-slide__thumbnail">
			            <div class="slide-thumbnail__item">
				            <img src="/foto_not_found_90.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
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
						<div class="fast-review__slider images offer_prop_block_imgs" variant="<?=$arOffer['VARIANT'];?>">
							<div class="review-slide__main">
	                            <?foreach($arPhotos as $arOnePhoto):?>
									<div class="slide-main__item"">
										<img src="<?=$arOnePhoto['SRC']?>">
									</div>
	                            <?endforeach?>
							</div>
							<div class="review-slide__thumbnail">
	                            <?foreach($arPhotos as $key => $arOnePhoto):
	                                $resizedImage = CFile::ResizeImageGet(
	                                    $arOnePhoto['ID'],
	                                    [
	                                        'width' => 80,
	                                        'height' => 80,
	                                    ],
	                                    BX_RESIZE_IMAGE_PROPORTIONAL,
	                                    true
	                                );?>
									<div class="slide-thumbnail__item">
										<img src="<?=$resizedImage['src']?>">
									</div>
	                            <?endforeach?>
							</div>
						</div>
                    <?elseif (count($arResult['MORE_PHOTO'])):?>
						<div class="fast-review__slider images offer_prop_block_imgs" variant="<?=$arOffer['VARIANT'];?>">
							<div class="review-slide__main">
					            <?foreach($arResult['MORE_PHOTO'] as $arOnePhoto):?>
									<div class="slide-main__item"">
										<img src="<?=$arOnePhoto['SRC']?>">
									</div>
					            <?endforeach?>
							</div>
							<div class="review-slide__thumbnail">
					            <?foreach($arResult['MORE_PHOTO'] as $key => $arOnePhoto):
					                $resizedImage = CFile::ResizeImageGet(
					                    $arOnePhoto['ID'],
					                    [
					                        'width' => 80,
					                        'height' => 80,
					                    ],
					                    BX_RESIZE_IMAGE_PROPORTIONAL,
					                    true
					                );?>
									<div class="slide-thumbnail__item">
										<img src="<?=$resizedImage['src']?>">
									</div>
					            <?endforeach?>
							</div>
						</div>
	                <?else:?>
						<div class="fast-review__slider images offer_prop_block_imgs" variant="<?=$arOffer['VARIANT'];?>">
							<div class="review-slide__main">
								<div class="slide-main__item">
									<img src="/foto_not_found_510.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
								</div>
							</div>

							<div class="review-slide__thumbnail">
								<div class="slide-thumbnail__item">
									<img src="/foto_not_found_90.jpg" alt="<?=htmlspecialchars($arResult["NAME"])?>">
								</div>
							</div>
						</div>
	                <?endif?>
                <?endforeach?>
            <?endif?>
		</div>
		<div class="product-info__col product-review__right">
			<div class="product-header">
                <?if($haveOffers):?>
                    <?foreach($arResult['OFFERS'] as $keyOffer => $arOffer):?>
		                <h2 class="product-header offer_prop_block" variant="<?=$arOffer['VARIANT'];?>">
                            <?=!empty($arOffer["NAME"]) ? $arOffer["NAME"] : $name?>
		                </h2>
                    <?endforeach?>
                <?else:?>
	                <h2><?=$name?></h2>
                <?endif?>
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
									<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
								</svg>
							</div>
							<div class="rating-stars__item <?=($averageMark >= 2)?'active-star':''?>">
								<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
								</svg>
							</div>
							<div class="rating-stars__item <?=($averageMark >= 3)?'active-star':''?>">
								<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
								</svg>
							</div>
							<div class="rating-stars__item <?=($averageMark >= 4)?'active-star':''?>">
								<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
								</svg>
							</div>
							<div class="rating-stars__item <?=($averageMark >= 5)?'active-star':''?>">
								<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
								</svg>
							</div>
						</div>
						<div class="rate-item rating-number">
                            <?=round($averageMark, 1)?>
						</div>
						<div class="rate-item rating-comment js-leave-comment" data-product-id="<?=$arResult["ID"]?>">
							Оставить отзыв
						</div>
                        <? if ($haveOffers):
                            foreach ($arResult['OFFERS'] as $keyOffer => $arOffer): ?>
                                <? if ($article = $arOffer["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]): ?>
									<div class="rate-item rating-articul offer_prop_block js-catalog-detail-articul"
									     data-value="<?=trim($article, '*');?>"
									     variant="<?=$arOffer['VARIANT'];?>"
									     prop_art = "<?=trim($article, '*')?>">
										Артикул <?=trim($article, '*');?>
									</div>
                                <? endif; ?>
                            <? endforeach; ?>
                        <?else:?>
                            <? if ($article = $arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]): ?>
								<div class="rate-item rating-articul js-catalog-detail-articul"
								     data-value="<?=trim($article, '*');?>">
									Артикул <?=trim($article, '*');?>
								</div>
                            <?endif;
                        endif;?>
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
								<div class="item-price__old product-price__old">
                                    <?=$arOffer['MIN_PRICE']['PRINT_VALUE'];?>
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
                                    Форма запроса на оптовые цены
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
		                <div class="product-btns review-btns buy offers_buy_block offer_prop_block"
		                     prod_id="<?=$arOffer['ID']?>"
		                     variant="<?=$arOffer['VARIANT'];?>">
                            <?if($arOffer['CATALOG_AVAILABLE'] != "Y" || empty($arOffer['CATALOG_QUANTITY'])): ?>
                                <div class="review-btns__row">
	                                <div class="item-buy__btn product-btn js-item-subscribe-item"
	                                     data-item_id="<?=$arOffer['ID']?>"
	                                     data-text_off="Уведомить о поступлении"
	                                     data-text_on="Отписаться от уведомлений"
	                                     style="width: 220px;">Уведомить о поступлении</div>
                                </div>
                            <?php else: ?>
				                <div class="review-btns__row">
					                <div class="item-counter review-counter">
						                <span class="item-counter__minus counter-limit"></span>
						                <input type="text" class="item-counter__number js-product-quantity" value="1" data-min="1">
						                <span class="item-counter__plus <?= ($arOffer["AVAILABLE_QUANTITY"] == 1) ? 'counter-limit' : '' ?>"></span>
					                </div>
	                                <div class="item-buy__btn product-btn review-buy js_add_to_cart js_product_page"
	                                     data-img="<?=$resizedSmallImage?>"
	                                     data-title="<?= $arResult["NAME"]; ?>">Купить</div>
				                </div>
                            <?php endif; ?>

			                <div class="review-btns__row">
				                <div class="review-btns__fav">
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
                                <?if($arOffer['CATALOG_AVAILABLE'] != "Y" || empty($arOffer['CATALOG_QUANTITY'])): ?>
                                <?php else: ?>
					                <div class="item-buy__click product-btn review-click quick_buy_product_card js-load-web-form-pop-up"
					                     data-web_form_text_id="buy_one_click"
					                     data-prod_href="<?=$arResult['DETAIL_PAGE_URL']?>">Купить в 1 клик</div>
                                <?php endif; ?>
			                </div>
		                </div>
	                <?endforeach?>
                <?else:?>
					<div class="product-btns review-btns buy offers_buy_block">
						<div class="review-btns__row">
							<div class="item-counter review-counter">
								<span class="item-counter__minus"></span>
								<input type="text" class="item-counter__number js-product-quantity" value="1" data-min="1">
								<span class="item-counter__plus"></span>
							</div>
							<div class="item-buy__btn product-btn review-buy js_add_to_cart js_product_page">Купить</div>
						</div>
						<div class="review-btns__row">
							<div class="review-btns__fav">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/compare.svg" alt="">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/like.svg" alt="">
							</div>
							<div class="item-buy__click product-btn review-click review-click quick_buy_product_card js-load-web-form-pop-up"
							     data-web_form_text_id="buy_one_click"
							     data-prod_href="<?=$arResult['DETAIL_PAGE_URL']?>">Купить в 1 клик</div>
						</div>
					</div>
                <?endif?>
			</div>
		</div>
	</div>
</div>
<div class="product-details">
	<a class="product-details__link" href="<?=$arResult['DETAIL_PAGE_URL']?>">Больше информации о товаре</a>
</div>

<!--<script>
    initCatalogDetail('<?='#product-info-' . $arResult['ID']?>');
</script>-->