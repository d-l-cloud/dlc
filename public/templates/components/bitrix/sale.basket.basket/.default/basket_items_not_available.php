<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bPriceType  = false;
$bDelayColumn  = false;
$bDeleteColumn = false;
$bPropsColumn  = false;
?>

<? foreach ($arResult["ITEMS"]["nAnCanBuy"] as $k => $arItem):
    if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
        $url = $arItem["PREVIEW_PICTURE_SRC"];
	elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
        $url = $arItem["DETAIL_PICTURE_SRC"];
    else:
        $url = "/foto_not_found_90";
    endif;
    ?>

	<div class="goodlist-item js-basket-item js-notavailable-item" data-item-id="<?=$arItem['ID']?>">
		<div class="goodlist-item__col goodlist-col__img">
			<div class="checkbox-item">
				<input class="custom-checkbox js-basket-item-checkbox"
				       data-panel-class="js-notavailable-panel"
				       type="checkbox"
				       id="ITEM_<?=$arItem['ID']?>">
				<label class="checkbox-label" for="ITEM_<?=$arItem['ID']?>"></label>
			</div>
			<img class="goodlist-img notavailable-img" src="<?=$url?>">
		</div>
		<div class="goodlist-item__col goodlist-item__info">
			<div class="goodlist-item__header">
                <?=$arItem['NAME']?>
			</div>
			<!--<div class="goodlist-item__features">
				Отверстие / поворотная кнопка: под цилиндр, цвет серый
			</div>-->
			<div class="goodlist-item__value">
				<div class="notavailable-price">
					Нет в наличии
				</div>
			</div>
		</div>
		<div class="goodlist-item__col goodlist-item__btn">
			<div class="goodlist-btns">
				<div class="goodlist-btns__fav">
					В избранное
				</div>
				<div class="goodlist-btns__delete js-basket-item-delete" data-item-id="<?=$arItem['ID']?>">
					Удалить
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>