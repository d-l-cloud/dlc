<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="news">
<? if (count($arResult["ITEMS"])): ?>
	<section class="sale">
		<h1 class="page-header">Акции</h1>
		<div class="sale-wrap">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="sale-item">
					<div class="sale-item__img">
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["~NAME"]?>">
						<div class="sale-item__type">
							<img src="img/sale/25-sale.svg" alt="">
						</div>
					</div>
					<div class="sale-item__text">
                        <?=$arItem["~NAME"]?>
					</div>
				</a>
            <? endforeach; ?>
		</div>
	</section>
	<section>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
        <?endif;?>
	</section>
<? else: ?>
	<div class=" lk-info__empty">
		<div class="info-empty__content" style="padding-top: 1%">
			<img src="<?=SITE_TEMPLATE_PATH?>/img/lk/order.svg" alt="" class="lk-empty__img">
			<div class="info-empty__header">
				Акции не найдены
			</div>
			<div class="info-empty__redirect">
				В данный момент нет акций
			</div>
		</div>
	</div>
<? endif; ?>
</div>