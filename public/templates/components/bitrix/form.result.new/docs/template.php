<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>

<?= $arResult["FORM_NOTE"] ?>

<? if ($arResult["isFormNote"] != "Y"): ?>
<?= $arResult["FORM_HEADER"] ?>
    <?php foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):
        if ($arQuestion["CAPTION"] == 'Юр. лицо' && empty($arResult['USER_PROFILES'])) {
            continue;
        } ?>
        <? if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'):
            echo $arQuestion["HTML_CODE"];
        else: ?>
            <?php if ($arQuestion["CAPTION"] == 'Профиль'): ?>
		        <div class="info-docs__row">
			        <select name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>" class="select">
                        <? foreach ($arResult['USER_PROFILES'] as $profileName): ?>
	                        <option value="<?= $profileName ?>" class="select-item"><?= $profileName ?></option>
                        <? endforeach; ?>
			        </select>
		        </div>
			<?php elseif ($FIELD_SID == 'CHECKBOXES_ROW'): ?>
		        <div class="info-docs__row docs-multy">
                    <?php foreach ($arQuestion as $FIELD_SID_SUB => $arSubQuestion): ?>
	                    <div class="info-docs__col">
		                    <div class="multy-checbox">
			                    <div class="multy-checbox__label">
                                    <?= $arSubQuestion["CAPTION"] ?>
			                    </div>
			                    <?php foreach ($arSubQuestion['STRUCTURE'] as $arStructure): ?>
				                    <div class="multy-checbox__item">
					                    <div class="checkbox-item">
						                    <input class="custom-checkbox" type="checkbox" id="<?=$FIELD_SID_SUB . $arStructure['ID']?>" name="form_checkbox_<?=$FIELD_SID_SUB?>[]" value="<?=$arStructure['ID']?>">
						                    <label class="checkbox-label" for="<?=$FIELD_SID_SUB . $arStructure['ID']?>"><?=$arStructure['MESSAGE']?></label>
					                    </div>
				                    </div>
			                    <?php endforeach; ?>
		                    </div>
	                    </div>
                    <? endforeach; ?>
		        </div>
	        <?php elseif ($FIELD_SID == 'INPUT_TEXT_ROW'): ?>
		        <div class="info-docs__row docs-double__input">
                <?php foreach ($arQuestion as $FIELD_SID_SUB => $arSubQuestion): ?>
			        <div class="info-docs__col docs-col__input" style="position: relative">
				        <input type="<?=$arSubQuestion['STRUCTURE'][0]['FIELD_TYPE']?>"
				               name="form_<?=$arSubQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arSubQuestion['STRUCTURE'][0]['ID']?>"
				               class="input docs-input"
				               placeholder="<?=$arSubQuestion['CAPTION']?>">
			        </div>
                <? endforeach; ?>
		        </div>
	        <?php else: ?>
		        <div class="info-docs__row" style="position: relative">
			        <textarea class="textarea docs-textarea"
			                  name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>"
			                  cols="10" rows="10" placeholder="<?=$arQuestion['CAPTION']?>"></textarea>
		        </div>
	        <?php endif; ?>
        <?php endif; ?>
    <? endforeach; ?>

	<input type="hidden" name="web_form_submit" value="Отправить" />
	<input type="hidden" name="web_form_apply" value="Y" />


	<div class="info-docs__row">
		<div class="docs-conditions">
			<div class="checkbox-item">
				<input class="custom-checkbox" type="checkbox" name="agree" id="feedback_agree_<?=$arResult["arForm"]["ID"];?>">
				<label class="checkbox-label" for="feedback_agree_<?=$arResult["arForm"]["ID"];?>">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include", "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/bitrix/include/privacy_policy.php"
                        ]); ?>
				</label>
			</div>
		</div>
	</div>


	<div class="info-docs__row">
		<button class="login-btn request-btn" type="submit" name="web_form_apply">Запросить</button>
	</div>

    <?= $arResult["FORM_FOOTER"] ?>
<? endif; ?>