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

<div class="documents-items">
    <? $APPLICATION->ShowViewContent('filter_by_year'); ?>

	<div class="articles-wrap">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
	        <a class="articles-item" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
		        <div class="articles-img">
			        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>" style="max-width: 290px;">
		        </div>
		        <div class="articles-text">
			        <div class="articles-text__header">
                        <?= $arItem["NAME"] ?>
			        </div>
			        <div class="articles-text__p">
                        <?= $arItem["PREVIEW_TEXT"] ?>
			        </div>
		        </div>
	        </a>
        <? endforeach; ?>
	</div>
</div>
<section>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</section>