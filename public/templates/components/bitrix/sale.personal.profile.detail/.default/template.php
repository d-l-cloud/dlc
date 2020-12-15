<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true){die();}

use Bitrix\Main\Localization\Loc;
if(strlen($arResult["ID"])>0):
    ShowError($arResult["ERROR_MESSAGE"]);
    ?>

	<h2 class="popup-header">Изменить компанию</h2>
	<form action="<?=POST_FORM_ACTION_URI?>" method="post"
	      enctype="multipart/form-data" class="change-company-form form-validate js-change-company-form">
        <?=bitrix_sessid_post()?>
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

		<div class="company-input">
			<div class="login-input">
				<input class="input" name="NAME" type="text" required value="<?=$arResult["NAME"]?>">
				<label class="input-label">Название</label>
			</div>
		</div>

		<div class="company-input">
			<div class="login-input">
				<input class="input mask-inn-organization"
				       autocomplete="off" autocorrect="off"
				       autocapitalize="off" spellcheck="false"
				       name="UF_INN" type="text" required
				       value="<? $APPLICATION->ShowProperty('PROPERTY_UF_INN_VALUE'); ?>">
				<label class="input-label">ИНН</label>
			</div>
		</div>

		<div class="adress-input double-input">
			<div class="login-input">
				<input class="input mask-kpp"
				       autocomplete="off" autocorrect="off"
				       autocapitalize="off" spellcheck="false"
				       name="UF_KPP" type="text"
				       value="<? $APPLICATION->ShowProperty('PROPERTY_UF_KPP_VALUE'); ?>">
				<label class="input-label">КПП</label>
			</div>
			<div class="login-input">
				<input class="input mask-bik"
				       autocomplete="off" autocorrect="off"
				       autocapitalize="off" spellcheck="false"
				       name="UF_BIK" type="text" required
				       value="<? $APPLICATION->ShowProperty('PROPERTY_UF_BIK_VALUE'); ?>">
				<label class="input-label">БИК</label>
			</div>
		</div>

        <?php foreach($arResult["ORDER_PROPS"] as $block): ?>
            <?php if (!empty($block["PROPS"])): ?>
                <?php foreach($block["PROPS"] as $property):
                    $key = (int)$property["ID"];
                    // Для полноценного сохранения $name должен быть "ORDER_PROP_".$key
                    // Сейчас данные не сохраняются, а отправляются письмом менеджеру.
                    // Поэтому, в данном случае, удобней использовать CODE.
                    $name = $property['CODE'];
                    $currentValue = $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$key];

                    if (in_array($name, ['ADDRESSES', 'UF_KPP', 'UF_INN', 'UF_BIK'])) {
                    	$APPLICATION->SetPageProperty('PROPERTY_'.$name.'_VALUE', $currentValue);
                        continue;
                    }
                    $maskClass = '';
                    switch ($name) {
	                    case 'UF_ACCOUNT':
	                    	$maskClass = 'mask-account';
                    }

                    if ($property["TYPE"] == "TEXT"): ?>
	                    <div class="company-input">
		                    <div class="login-input">
			                    <input class="input <?=$maskClass?>"
			                           autocomplete="off" autocorrect="off"
			                           autocapitalize="off" spellcheck="false"
			                           name="<?=$name?>"
			                           type="text" <?= ($property["REQUIED"] == "Y") ? 'required' : ''?>
			                           value="<?=$currentValue?>">
			                    <label class="input-label"><?= $property["NAME"]?></label>
		                    </div>
	                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
		<input type="hidden" class="btn-primary" name="save" value="Сохранить">

		<button class="blue-btn company-btn" type="submit">Сохранить</button>
	</form>
<?php else:
	ShowError($arResult["ERROR_MESSAGE"]);
endif; ?>