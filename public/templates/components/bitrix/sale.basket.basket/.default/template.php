<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */

$obAsset = \Bitrix\Main\Page\Asset::getInstance();
$obAsset->addJs(SITE_TEMPLATE_PATH . '/dist/js/basket.js');

$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"],
	'EVENT_ONCHANGE_ON_START' => (!empty($arResult['EVENT_ONCHANGE_ON_START']) && $arResult['EVENT_ONCHANGE_ON_START'] === 'Y') ? 'Y' : 'N'
);
?>


<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
$iDelCount = count($arResult["ITEMS"]["nAnCanBuy"]);

$count_text = wordCountEndings($normalCount, 'товар', 'товара', 'товаров');
?>

<? if (strlen($arResult["ERROR_MESSAGE"]) <= 0): ?>
	<article>
		<div class="basket">
			<h1 class="page-header">
				Корзина
			</h1>
			<form id="basket-form" class="basket-inner">
                <?=bitrix_sessid_post()?>
				<input type="hidden" name="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
				<input type="hidden" name="basketAction" value="recalculate" />
				<div class="basket-inner__left">
					<div class="warranty-notice">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/basket/warranty-notification.svg" class="warranty-notice__img">
						<p>На весь ассортимент нашего магазина распространяется гарантия производителя, а также наша собственная. Гарантийный срок составляет 1 год со дня покупки, если не указано иное на странице товара. Условием исполнения гарантии является платежный документ, выданный с товаром.</p>
					</div>

					<div class="goodslist-panel js-basket-panel js-available-panel">
						<div class="check-all">
							<div class="checkbox-item">
								<input class="custom-checkbox js-basket-item-checkbox-all"
								       data-item-class="js-available-item"
								       type="checkbox"
								       id="ITEM_AVAILABLE_ALL">
								<label class="checkbox-label" for="ITEM_AVAILABLE_ALL"">Выбрать все</label>
							</div>
						</div>
						<div class="goods-panel__amount">
							Всего <span class="js-basket-value" data-name="ITEMS_COUNT"><?=$normalCount?> <?=$count_text?></span>
						</div>

						<div class="goodlist-btns">
							<div class="goodlist-btns__fav js-basket-item-favorite"
							     data-item-class="js-available-item"
							     style="display: none">
								В избранное
							</div>
							<div class="goodlist-btns__delete js-basket-item-delete"
							     data-item-class="js-available-item"
							     style="display: none">
								Удалить
							</div>
						</div>
					</div>
	                <?
	                include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/basket_items.php");
	                ?>

	                <? if ($iDelCount > 0): ?>
						<div class="goodslist-panel notavailable js-basket-panel js-notavailable-panel">
							<div class="check-all">
								<div class="checkbox-item">
									<input class="custom-checkbox js-basket-item-checkbox-all"
									       data-item-class="js-notavailable-item"
									       type="checkbox"
									       id="ITEM_NOTAVAILABLE_ALL">
									<label class="checkbox-label" for="ITEM_NOTAVAILABLE_ALL">Выбрать все</label>
								</div>
							</div>
							<div class="goods-panel__amount">
								Недоступно для заказа
							</div>

							<div class="goodlist-btns">
								<div class="goodlist-btns__fav js-basket-item-favorite" data-item-class="js-notavailable-item">
									В избранное
								</div>
								<div class="goodlist-btns__delete js-basket-item-delete" data-item-class="js-notavailable-item">
									Удалить
								</div>
							</div>
						</div>

	                    <?
	                    include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/basket_items_not_available.php");
	                    ?>
	                <? endif; ?>
				</div>
				<div class="basket-inner__right">
					<div class="basket-total">
						<div class="total-row">
							<div class="total-col">
								<div class="total-goods js-basket-value" data-name="ITEMS_COUNT">
									<?=$normalCount?> <?=$count_text?>
								</div>
							</div>
							<? if ($allWeight > 0): ?>
								<div class="total-col">
									<div class="total-weight js-basket-value" data-name="allWeight_FORMATED">
										<?=$arResult['allWeight_FORMATED']?>
									</div>
								</div>
							<? endif; ?>
						</div>
						<div class="total-row">
							<div class="total-col">
								<div class="total-val">
									Сумма
								</div>
							</div>
							<div class="total-col">
								<div class="total-sum js-basket-value" data-name="PRICE_WITHOUT_DISCOUNT">
									<?=$arResult['PRICE_WITHOUT_DISCOUNT']?>
								</div>
							</div>
						</div>
	                    <? if ($arResult['DISCOUNT_PRICE_ALL'] > 0): ?>
						<div class="total-row row-border js-basket-field" data-name="DISCOUNT_PRICE_ALL_FORMATED">
							<div class="total-col">
								<div class="total-val">
									Скидка
								</div>
							</div>
							<div class="total-col">
								<div class="total-discount">
									- <span class="js-basket-value" data-name="DISCOUNT_PRICE_ALL_FORMATED"><?=$arResult['DISCOUNT_PRICE_ALL_FORMATED']?></span>
								</div>
							</div>
						</div>
	                    <? endif; ?>
						<div class="total-row row-result">
							<div class="total-col">
								<div class="total-val">
									Общая стоимость
								</div>
							</div>
							<div class="total-col">
								<div class="total-result js-basket-value" data-name="allSum_FORMATED">
									<?=$arResult['allSum_FORMATED']?>
								</div>
							</div>
						</div>

						<a href="/personal/cart/order/" class="basket-checkout-btn checkout-btn">
							Перейти к оформлению
						</a>
					</div>
				</div>
			</form>
		</div>
	</article>
<? else:?>
<article>
	<div class="news">
		<div class=" lk-info__empty">
			<div class="info-empty__content" style="padding-top: 1%">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/lk/order.svg" alt="" class="lk-empty__img">
				<div class="info-empty__header">
					В корзине ничего нет
				</div>
				<div class="info-empty__redirect">
					Перейдите в <a href="/katalog/" class="link-blue">Каталог</a> для оформления заказа
				</div>
			</div>
		</div>
	</div>
</article>
<?endif; ?>

<?php ob_start() ?>
<!--Delete Confirmation -->
<div class="popup-layout delete-confirm-layout">
	<div class="delete-confirm popup-delete">
		<div class="delete-header">Точно удалить?</div>
		<div class="delete-btns">
			<button class="delete-btns__y js-basket-item-delete-confirm">Да</button>
			<button class="delete-btns__n js-close-popup">Нет</button>
		</div>
	</div>
</div>
<?php
$APPLICATION->AddViewContent('popups', ob_get_clean());
?>
