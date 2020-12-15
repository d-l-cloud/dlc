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
	<h1 class="page-header">Новости компании</h1>

    <? $APPLICATION->ShowViewContent('filter_by_year'); ?>

	<div class="news-wrap">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
			<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="last-news__item news-page-item">
				<? if (!empty($arItem["PREVIEW_PICTURE"])): ?>
					<div class="news-item__img">
						<img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
					</div>
				<? endif; ?>
				<div class="news-item__header">
                    <?= $arItem["NAME"] ?>
				</div>
				<div class="news-item__description">
                    <?= $arItem["PREVIEW_TEXT"] ?>
				</div>
			</a>
        <? endforeach; ?>
	</div>

	<section>
        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
            <?= $arResult["NAV_STRING"] ?>
        <? endif; ?>
	</section>
</div>