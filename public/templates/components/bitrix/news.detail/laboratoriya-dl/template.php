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

<div class="news-detail">
	<div class="news-detail-wrap">
		<h1 class="page-header">
            <?= $arResult["NAME"] ?>
		</h1>

        <? if (is_array($arResult["DETAIL_PICTURE"])):?>
			<div class="singlepage-img">
				<img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
				     alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
				     title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>">
			</div>
        <?endif;?>

		<div class="singlepage-textblock">
            <? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
                <?= $arResult["DETAIL_TEXT"]; ?>
            <? else: ?>
                <?= $arResult["PREVIEW_TEXT"]; ?>
            <? endif ?>
		</div>
	</div>
</div>