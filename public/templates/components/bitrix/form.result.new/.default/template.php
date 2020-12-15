<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<h2 class="popup-header"><?=$arResult["FORM_TITLE"]?></h2>
<?=$arResult["FORM_HEADER"]?>
    <?php if ($arResult["isFormErrors"] == "Y"): ?>
        <?= $arResult["FORM_ERRORS_TEXT"] ?>
    <?php endif ?>

    <?php if ($arResult["isFormNote"] != "Y"): ?>
        <?foreach($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):
            $isVisible = true;

            if ($arQuestion['STRUCTURE'][0]['ID'] == 4
                || $arQuestion['STRUCTURE'][0]['ID'] == 7
                || $FIELD_SID == 'product_quantity'
                || $FIELD_SID == 'product_offer_code'
            ) {
                $isVisible = false;
            }
            ?>

	        <?php if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'): ?>
	            <?= $arQuestion["HTML_CODE"] ?>
	        <?php else: ?>
	            <?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'textarea'):?>
					<div class="login-input" <?if(!$isVisible):?>style="display:none"<?endif?>>
						<textarea class="textarea"
						          name="form_textarea_<?= $arQuestion['STRUCTURE'][0]['ID']; ?>"
						          cols="30" rows="10"
						          placeholder="<?= $arQuestion["CAPTION"] ?>"
						          <?= $arQuestion["REQUIRED"] == "Y" ? 'required' : '' ?>
						          data-form_question_sid="<?=$FIELD_SID?>"></textarea>
					</div>
	            <?php else:
	                if ($arQuestion['STRUCTURE'][0]['ID'] == 2
	                    || $arQuestion['STRUCTURE'][0]['ID'] == 6
	                    || $arQuestion['STRUCTURE'][0]['ID'] == 9
	                    || $arQuestion['STRUCTURE'][0]['ID'] == 12
	                    || $arQuestion['STRUCTURE'][0]['QUESTION_ID'] == 23
	                ) {
	                    $type = 'tel';
	                } else if ($arQuestion['STRUCTURE'][0]['ID'] == 10) {
	                    $type = 'email';
	                } else {
	                    $type = 'text';
	                } ?>
					<div class="login-input feddback-name" <?if(!$isVisible):?>style="display:none"<?endif?>>
						<input class="input <?=($type == 'tel') ? 'valid-phone' : 'valid-name'?>"
						       name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']; ?>"
						       type="<?=$type?>"
				               <?= $arQuestion["REQUIRED"] == "Y" ? 'required' : '' ?>
				               data-form_question_sid="<?=$FIELD_SID?>">
						<label class="input-label" for=""><?= $arQuestion["CAPTION"] ?></label>
					</div>
	                <?php if ($type == 'tel'): ?>
						<script data-skip-moving="true">
		                    $('.input[name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']; ?>"]').inputmask('+7 (999) 999-99-99');
						</script>
	                <?php endif; ?>
	            <?php endif ?>
	        <?php endif ?>
        <?endforeach?>


	    <? if (!$arParams['NOT_USE_CUSTOM_CAPTCHA']): ?>
			<div id="grecaptcha_<?= $arResult["arForm"]["ID"]; ?>" class="grecaptcha_cont"></div>
	    <? endif; ?>

		<div style="position:relative;">
			<div class="checkbox-item">
				<input class="custom-checkbox" type="checkbox" name="feedback_agree" required
				       id="feedback_agree_<?= $arResult["arForm"]["ID"]; ?>">
				<label class="checkbox-label" for="feedback_agree_<?= $arResult["arForm"]["ID"]; ?>">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include", "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/bitrix/include/privacy_policy.php"
                        ]);
                    ?>
			</div>
		</div>
		<div class="form-login__btns">
			<button class="login-btn register-btn active-btn" type="submit">
	            <?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
			</button>
		</div>
		<input type="hidden" name="web_form_submit" value="Отправить"/>
		<input type="hidden" name="web_form_apply" value="Y"/>
    <?php endif ?>
<?=$arResult["FORM_FOOTER"]?>