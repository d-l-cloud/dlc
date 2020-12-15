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

<section class="sale-detail">
	<h1 class="page-header"><?=$arResult['NAME']?></h1>
	<div class="sale-detail__info">
		<div class="sale-detail__img">
			<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult['NAME']?>">
			<!--<div class="sale-item__type">
				<img src="img/sale/25-sale.svg" alt="">
			</div>-->
		</div>
		<div class="sale-detail__text">
            <? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
                <?= $arResult["DETAIL_TEXT"]; ?>
            <? else: ?>
                <?= $arResult["PREVIEW_TEXT"]; ?>
            <? endif ?>
		</div>
	</div>
</section>