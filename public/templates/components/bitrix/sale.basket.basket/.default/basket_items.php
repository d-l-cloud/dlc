<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */

if (!empty($arResult["ERROR_MESSAGE"])) {
    ShowError($arResult["ERROR_MESSAGE"]);
}

$bDelayColumn = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn = false;
$bPriceType = false;

if ($normalCount > 0):
	global $cart_not_empty;
	$cart_not_empty = 1;
	?>

    <? foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $k => $arItem):
	    if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
	        $url = $arItem["PREVIEW_PICTURE_SRC"];
		elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
	        $url = $arItem["DETAIL_PICTURE_SRC"];
	    else:
	        $url = "/foto_not_found_90";
	    endif;
	    ?>
		<div class="goodlist-item js-basket-item js-available-item" data-item-id="<?=$arItem['ID']?>">
			<div class="goodlist-item__col goodlist-col__img">
				<div class="checkbox-item">
					<input class="custom-checkbox js-basket-item-checkbox"
					       data-panel-class="js-available-panel"
					       type="checkbox"
					       id="ITEM_<?=$arItem['ID']?>">
					<label class="checkbox-label" for="ITEM_<?=$arItem['ID']?>"></label>
				</div>
				<img class="goodlist-img" src="<?=$url?>" alt="">
			</div>
			<div class="goodlist-item__col goodlist-item__info">
				<a class="goodlist-item__header" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <?=$arItem['NAME']?>
				</a>
				<!--<div class="goodlist-item__features">
					Отверстие / поворотная кнопка: под цилиндр, цвет серый
				</div>-->
				<div class="goodlist-item__value">
					<div class="counter-wrap">
						<div class="item-counter goodlist-item__counter">
							<span class="item-counter__minus <?= ($arItem['QUANTITY'] == 1) ? 'counter-limit' : '' ?>"></span>
							<input type="text" class="item-counter__number goodlist-item__number js-basket-item-quantity"
							       id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
							       name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
							       value="<?=$arItem['QUANTITY']?>"
							       data-item-id="<?=$arItem["ID"]?>"
							       data-min="1" data-max="<?=$arItem["AVAILABLE_QUANTITY"]?>">
							<span class="item-counter__plus <?= ($arItem['QUANTITY'] == $arItem["AVAILABLE_QUANTITY"]) ? 'counter-limit' : '' ?>"></span>

							<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
						</div>
						<div class="goods-remains <?= ($arItem['QUANTITY'] == $arItem["AVAILABLE_QUANTITY"]) ? '' : 'goods-remains-hidden' ?>">Доступно <?=$arItem["AVAILABLE_QUANTITY"]?> шт.</div>
					</div>
					<div class="goodlist-item__pricing">
						<div class="product-price goodlist-price">
							<div class="item-price__current goodlist-price__current js-basket-item-value" data-name="SUM"><?=$arItem['SUM']?></div>
                            <? if ($arItem['BASE_PRICE'] > $arItem['PRICE']): ?>
								<div class="item-price__old goodlist-price__old">
									<span class="js-basket-item-value" data-name="SUM_FULL_PRICE_FORMATED"><?=$arItem['SUM_FULL_PRICE_FORMATED']?></span>
									<? if ($arItem['DISCOUNT_PRICE_PERCENT'] > 0): ?>
										<div class="item-price__discount product-price__discount">
											-<?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?>
										</div>
	                                <? endif; ?>
								</div>
                            <? endif; ?>
						</div>
					</div>
					<div class="goodlist-wholesale js-basket-item-field" <?=($arItem['QUANTITY'] > 1) ? '' : 'style="display: none;"'?>
					     data-name="QUANTITY_SUM"><?=$arItem['PRICE_FORMATED']?> х <span class="js-basket-item-value" data-name="QUANTITY_SUM"><?=$arItem['QUANTITY']?></span></div>
				</div>
			</div>
			<div class="goodlist-item__col goodlist-item__btn">
				<div class="goodlist-btns">
					<div class="goodlist-btns__fav js-item-favourites favourites-basket" data-product_id="<?=$arItem['PRODUCT_ID']?>">
						В избранное
					</div>
					<div class="goodlist-btns__delete js-basket-item-delete" data-item-id="<?=$arItem['ID']?>">
						Удалить
					</div>
				</div>
			</div>
		</div>
    <?php endforeach; ?>
<? else: ?>
	<table>
		<tbody>
			<tr>
				<td style="text-align:center">
					<div class=""><?=(!empty($_GET['COPY'])) ? ShowError(GetMessage("SALE_NO_ITEMS_COPY")) : ShowError(GetMessage("SALE_NO_ITEMS"))?></div>
				</td>
			</tr>
		</tbody>
	</table>
<? endif; ?>