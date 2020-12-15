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

<?php if(count($arResult["ITEMS"])): ?>
	<section>
		<div class="brands">
			<h2 class="slider-header">Наши бренды</h2>
			<div class="brands-slider additional-slider">
	            <?php foreach($arResult["ITEMS"] as $arItem):?>
		            <a href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>" class="brands-item">
                        <?php if($arItem["PREVIEW_PICTURE_RESIZED_SRC"]):?>
	                        <img src="<?= $arItem["PREVIEW_PICTURE_RESIZED_SRC"] ?>" alt="<?= $arItem["~NAME"] ?>">
                        <?php endif; ?>
		            </a>
	            <?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>