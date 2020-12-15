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

$arSetFilters = [];
global $arSetFilters;
?>

<form class="video-filters js-video-filters" name="<?= $arResult["FILTER_NAME"]."_form" ?>" action="<?= $arResult["FORM_ACTION"] ?>" method="get">
	<input type="hidden" name="ajax" value="y">
    <?php foreach ($arResult["HIDDEN"] as $arItem): ?>
		<input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>"
		       id="<? echo $arItem["CONTROL_ID"] ?>"
		       value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <?php endforeach; ?>

	<?php foreach ($arResult["ITEMS"] as $key => $arItem):
        if (empty($arItem["VALUES"])) {
            continue;
        }

        if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)) {
            continue;
        }
        ?>
		<div class="video-filters__item">
            <?= $arItem["NAME"] ?>
			<div class="video-selector__list">
                <?php foreach($arItem["VALUES"] as $val => $ar):
	                if ($ar['CHECKED']) {
                        $arSetFilters[$ar["CONTROL_NAME_ALT"]] = [
                        	'VALUE' => $ar["HTML_VALUE_ALT"],
	                        'TITLE' => $ar["VALUE"],
                        ];
	                } ?>
					<div class="video-selector__option">
						<div class="checkbox-item">
							<input class="custom-checkbox"
							       type="radio"
							       id="<?= $ar["CONTROL_ID"] ?>"
							       name="<?= $ar["CONTROL_NAME_ALT"] ?>"
							       value="<?= $ar["HTML_VALUE_ALT"] ?>" <?= $ar["CHECKED"]? 'checked="checked"': '' ?>>
							<label class="checkbox-label" for="<?= $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
						</div>
					</div>
                <?php endforeach; ?>
			</div>
			<span class="statick-tick"></span>
		</div>
    <?php endforeach; ?>
</form>