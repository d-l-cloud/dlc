<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($arResult)): ?>
	<div class="footer-col">
        <?php
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
                continue;
            }
            $arClasses = ['footer-documents'];
            if (!empty($arItem['PARAMS']['CLASSES'])) {
            	$arClasses = array_merge($arClasses, $arItem['PARAMS']['CLASSES']);
            }
            ?>
	        <a class="<?= implode(' ', $arClasses) ?>" href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
        <?php endforeach ?>
	</div>
<?php endif ?>