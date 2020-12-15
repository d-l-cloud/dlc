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

<?php if(count($arResult["ITEMS"])):?>
	<section>
		<div class="main-slider">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php if($arItem["PREVIEW_PICTURE"]["SRC"]): ?>
		            <a class="main-slider__item" href="<?= $arItem["PROPERTIES"]["URL"]["VALUE"]; ?>">
			            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" alt="">
			            <div class="main-slider__text">
                            
			            </div>
		            </a>
                <?php endif; ?>
            <?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>