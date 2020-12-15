<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

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

if (isset($arResult['ITEM'])) {
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


	$obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
	$isBig = isset($arResult['BIG']) && $arResult['BIG'] === 'Y';

	$productTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $item['NAME'];

	$imgTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $item['NAME'];

	$skuProps = array();

    $technicalProperties = [];
    foreach ($item['PROPERTIES'] as $key => $property) {
        if (isset($product_technical_property_ids[$property['ID']])) {
            $property['comment'] = $product_technical_property_ids[$property['ID']]['comment'];
            $technicalProperties[$key] = $property;
        }
    }

	$haveOffers = !empty($item['OFFERS']);
	$offersCount = 0;
	if ($haveOffers) {
        if (isset($item['OFFERS'][$item['OFFERS_SELECTED']])) {
            $actualItem = $item['OFFERS'][$item['OFFERS_SELECTED']];
        } else {
            $minPriceTmp = false;
            foreach ($item['OFFERS'] as $key => $offer) {
                $price = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                if($minPriceTmp === false || $minPriceTmp > $price){
                    $minPriceTmp = $price;
                    $actualItem = $offer;
                }
            }
        }

        $arOffersProps = [];
        $arVariantProps = [];
        $offersTechProps = [];
        $noProp = [];
        $iter = 0;

        $usedProps = [];

        foreach ($item['OFFERS'] as $keyOffer => $arOffer) {
            foreach($arOffer['PROPERTIES'] as $arProp) {
                if($arProp['VALUE'] && $arProp['PROPERTY_TYPE'] == 'L' && $arProp['CODE'] != 'COLOR') {
                    $usedProps[$arProp['CODE']] = $arProp['CODE'];
                }
            }
        }

        foreach ($item['OFFERS'] as $keyOffer => $arOffer) {
        	if ($arOffer['ID'] != $actualItem['ID']) continue;

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
                    $item['OFFERS'][$keyOffer]['PROPERTIES'][$k]['VALUE'] = 'Нет';
                    $item['OFFERS'][$keyOffer]['PROPERTIES'][$k]['VALUE_ENUM_ID'] = $arProp['VALUE_ENUM_ID'] = $noProp[$k] ;
                }

                // строковым свойствам ставим VALUE_ENUM_ID для корректной работы радиокнопок
                if ($arProp['PROPERTY_TYPE'] == 'S' && !$arProp['VALUE_ENUM_ID']) {
                    $item['OFFERS'][$keyOffer]['PROPERTIES'][$k]['VALUE_ENUM_ID'] = $arProp['VALUE_ENUM_ID'] = md5($arProp['VALUE']);
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

            $item['OFFERS'][$keyOffer]['VARIANT'] = $variant;
        }

        // Габариты и вес торговых предложений нужно добавить в конец массива технических характеристик
        foreach ($item['OFFERS'] as $keyOffer => $arOffer) {
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

        $offersCount = count($item['OFFERS']);
	} else {
        // Габариты товара нужно добавить в конец массива технических характеристик
        if (!empty($item['CATALOG_WIDTH']) && !empty($item['CATALOG_LENGTH']) && !empty($item['CATALOG_HEIGHT'])) {
            $widthCm = $item['CATALOG_WIDTH'] / 10;
            $lengthCm = $item['CATALOG_LENGTH'] / 10;
            $heightCm = $item['CATALOG_HEIGHT'] / 10;

            $dimensionsCmString = $lengthCm . 'x' . $widthCm . 'x' . $heightCm;

            $technicalProperties['CATALOG_DIMENSIONS'] = [
                'NAME' => 'Размер (ДхШхВ), см',
                'SORT' => '999998',
                'VALUE' => $dimensionsCmString,
            ];
        }

        // Вес товара нужно добавить в конец массива технических характеристик
        if (!empty($item['CATALOG_WEIGHT'])) {
            $technicalProperties['CATALOG_WEIGHT'] = [
                'NAME' => 'Вес, кг',
                'SORT' => '999999',
                'VALUE' => $item['CATALOG_WEIGHT'] / 1000
            ];
        }

		$actualItem = $item;
	}

	// Сортировка свойств по полю "SORT"
    $arSortBySort = [];
    $arSortByName = [];
    foreach ($technicalProperties as $pKey => $arProp) {
        $arSortBySort[$pKey] = $arProp['SORT'];
        $arSortByName[$pKey] = $arProp['NAME'];
    }

    array_multisort($arSortBySort, SORT_ASC, $arSortByName, SORT_ASC, $technicalProperties);

	if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers) {
		$price = $item['ITEM_START_PRICE'];
		$minOffer = $item['OFFERS'][$item['ITEM_START_PRICE_SELECTED']];
		$measureRatio = $minOffer['ITEM_MEASURE_RATIOS'][$minOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
		$quantity = $minOffer['CATALOG_QUANTITY'];
	}

	if (!$price) {
		$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
		$measureRatio = $price['MIN_QUANTITY'];
		$quantity = $actualItem['CATALOG_QUANTITY'];
	}

	$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($item['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

	if ($brend_id = $item["PROPERTIES"]["BREND"]["VALUE"]) {
		$res = CIBlockElement::GetList(
            array(),
            array("IBLOCK_ID" => 3, "ID" => $brend_id),
            false,
            array("nTopCount" => 1),
            array("NAME", "PREVIEW_PICTURE", "PROPERTY_LINK")
        );

		$arBrend = $res->GetNext();
	}
?>
	<div class="item-horizontal">
		<a class="item-horizontal__col item-horizontal__img" href="<?= $item['DETAIL_PAGE_URL'] ?>">
            <?php if(!empty($item['RESIZED_PREVIEW_PICTURE_LIST_SRC'])): ?>
				<img src="<?=$item['RESIZED_PREVIEW_PICTURE_LIST_SRC']?>" alt="<?=$imgTitle?>"/>
            <?php endif; ?>
		</a>
		<div class="item-horizontal__col item-horizontal__char">
			<div class="chars-col js-catalog-chars">
                <?php if(!empty($technicalProperties)): ?>
                    <?foreach($technicalProperties as $code => $property):?>
                        <?if(!empty($property['OFFER_VALUES'])):?>
                            <?foreach($property['OFFER_VALUES'] as $variant => $value):?>
                                <?if($value != '' && $variant):?>
					                <div class="chars-col__row">
						                <div class="chars-props"><?=$property["NAME"];?></div>
						                <div class="chars-value">
                                            <?=$value?>
						                </div>
					                </div>
                                <?endif?>
                            <?endforeach?>
                        <?elseif($property["VALUE"] != ''):?>
			                <div class="chars-col__row">
				                <div class="chars-props"><?=$property["NAME"];?></div>
				                <div class="chars-value">
                                    <?if($code == "RELIABILITY"):?>
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
                                    <?elseif($code == "BREND" && isset($arBrend)):?>
                                        <?=$arBrend["NAME"]?>
                                    <?else:?>
                                        <?=$property["VALUE"]?>
                                    <?endif?>
				                </div>
			                </div>
                        <?endif?>
                    <?endforeach?>

	                <div class="char-more">
		                Еще характеристики
	                </div>
				<?php endif; ?>
			</div>
		</div>
		<div class="item-horizontal__col item-horizontal__btns">
			<div class="horizontal-col__inner">
				<div class="horizontal-rate">
                    <?php if(isset($actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']) && $actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
	                    <div class="rate-item rate-articul">
		                    Артикул <?= str_replace(['*', '#'], '',$actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']); ?>
	                    </div>
                    <?php endif?>
					<div class="horizontal-stars">
                        <?
                        $averageMark = floatval($item['PROPERTIES']['AVERAGE_MARK']['VALUE']);
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
						<div class="rate-item rate-number">
                            <?=round($averageMark, 1)?>
						</div>
					</div>
					<div class="to-fav-btns">
						<span class="js-item-compare fav-comp"
						      data-product_id="<?=$item['ID']?>" data-iblock="<?=$item['IBLOCK_ID']?>">
				            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
					            <rect x="6" y="14" width="8" height="12" rx="3" stroke="#1F3664" stroke-width="2"/>
					            <rect x="18" y="6" width="8" height="20" rx="3" stroke="#1F3664" stroke-width="2"/>
				            </svg>
						</span>
						<span class="js-item-favourites fav-heart" data-product_id="<?=$item['ID']?>">
				            <svg width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
					            <path d="M11.281 4.10271L12 4.84663L12.719 4.10271L14.2099 2.56023C16.2206 0.479926 19.4951 0.479927 21.5058 2.56023C23.4981 4.62143 23.4981 7.94965 21.5058 10.0108L12 19.8458L2.49417 10.0108C0.501943 7.94964 0.501944 4.62142 2.49417 2.56023C4.50487 0.479923 7.77941 0.479925 9.7901 2.56023L11.281 4.10271Z" stroke="#1F3664" stroke-width="2"/>
				            </svg>
						</span>
					</div>
				</div>
				<div class="item-price">
					<div class="item-price__current"><?= $price['PRINT_RATIO_PRICE'] ?></div>

                    <?if($arParams['SHOW_OLD_PRICE'] === 'Y' && $price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE']):?>
						<div class="item-price__old" id="<?=$itemIds['PRICE_OLD']?>">
                            <?=$price['PRINT_RATIO_BASE_PRICE']?>
						</div>
                    <?endif?>

                    <?php if($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && $price['PERCENT'] > 0): ?>
						<div class="item-price__discount">-<?= $price['PERCENT'] ?>%</div>
                    <?php endif; ?>
				</div>
				<a href="<?=$item['DETAIL_PAGE_URL'] ?>" class="item-description">
                    <?php
                    if (!empty($arParams['shirt_title']) && mb_strlen($productTitle) > 65) {
                        echo mb_substr($productTitle, 0, 65) . '...';
                    } else {
                        echo $productTitle;
                    }
                    ?>
				</a>
				<div class="item-buy">
				    <?if($actualItem['CATALOG_AVAILABLE'] != "Y" || empty($actualItem['CATALOG_QUANTITY'])): ?>
				    <?php else: ?>
						<div class="item-buy__btn js_add_to_cart js_product_list" data-product_id="<?= $actualItem['ID']; ?>">Купить</div>
						<div class="item-buy__click js-load-web-form-pop-up"
						     data-web_form_text_id="buy_one_click"
						     data-prod_href="<?=$item['DETAIL_PAGE_URL']?>"
						     data-article="<?=$actualItem['PROPERTIES']['CML2_ARTICLE']['VALUE']?>">Купить в 1 клик</div>
                    <?php endif; ?>
				</div>
                <?php if(!empty($item['OFFERS']) && $item['CATALOG_AVAILABLE'] == "Y"): ?>
					<a href="<?=$item['DETAIL_PAGE_URL'] ?>" class="item-variants">Еще <?= count($item['OFFERS']); ?> <?= wordCountEndings(count($item['OFFERS']), 'вариант', 'варианта', 'вариантов') ?></a>
                <?php endif; ?>
			</div>
		</div>
	</div>
	<?
	unset($item, $actualItem, $minOffer, $itemIds, $jsParams);
}