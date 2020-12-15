<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<article>
	<div class="vacancy">

	<?php if(count($arResult["ITEMS"])): ?>
		<h1 class="page-header">
			Вакансии
		</h1>
		<div class="vacancy-wrap">
            <?php foreach ($arResult["ITEMS"] as $arItem): ?>
				<div class="vacancy-item">
					<div class="vacancy-item__name">
                        <?= $arItem["NAME"] ?>
					</div>
					<div class="vacancy-item__text">
                        <?= $arItem["PREVIEW_TEXT"] ?>
					</div>
				</div>
            <?php endforeach; ?>
		</div>
	<?php else: ?>

		<div class=" lk-info__empty">
			<div class="info-empty__content" style="padding-top: 1%">
				<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
				<div class="info-empty__header">
					Нет вакансий
				</div>
				<div class="info-empty__redirect">
					В данный момент нет вакансий
				</div>
			</div>
		</div>
	<?php endif; ?>
	</div>
</article>