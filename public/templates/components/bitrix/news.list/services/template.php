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
<?php if (count($arResult["ITEMS"])): ?>
	<section>
		<div class="advantages">
			<h2 class="slider-header">Наши преимущества</h2>
			<div class="advantages-wrap">
				<?php foreach($arResult["ITEMS"] as $arItem): ?>
					<a href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>" class="advantages-item">
						<img src="<?= $arItem["IMAGE_SRC"] ?>" alt="<?= $arItem["~NAME"] ?>">
						<p><?= $arItem["~NAME"] ?></p>
					</a>
				<?php endforeach;?>
			</div>
		</div>
	</section>
<?php endif; ?>