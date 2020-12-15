<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (strlen($arResult["ERROR_MESSAGE"]) > 0) {
    ShowError($arResult["ERROR_MESSAGE"]);
}

if (count($arResult["PROFILES"])): ?>
	<div class="lk-entity">
    <?php foreach ($arResult["PROFILES"] as $profile):
        if ($profile['PERSON_TYPE_ID'] == 2) {
            continue;
        }
        ?>

		<div class="info-entity__row" data-profile="<?=$profile['ID']?>">
			<div class="info-personal__col entity-prop"><?= $profile["NAME"] ?></div>
			<div class="info-personal__col info-change change-company js-change-company" data-profile="<?=$profile['ID']?>">Изменить</div>
		</div>
    <?endforeach?>

		<div class="info-entity__row">
			<div class="add-new add-company"><span>+</span> Добавить юридическое лицо</div>
		</div>
	</div>
	<?php if (strlen($arResult["NAV_STRING"]) > 0): ?>
	    <?= $arResult["NAV_STRING"] ?>
	<?php endif; ?>
<?php else: ?>
	<div class="lk-entity">
		<h3>Список профилей пуст</h3>

		<div class="info-entity__row">
			<div class="add-new add-company"><span>+</span> Добавить юридическое лицо</div>
		</div>
	</div>
<?php endif; ?>