<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<form class="restore-password" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
    <?if (strlen($arResult["BACKURL"]) > 0): ?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <? endif ?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="CHANGE_PWD">

	<input type="hidden" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="input" />
	<input type="hidden" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="input" />

	<div class="login-input login-email">
		<input class="input" name="USER_PASSWORD" type="password" id="setup-forgot-pass-field-password">
		<label class="input-label">Новый пароль</label>
	</div>
	<div class="login-input login-email">
		<input class="input" name="USER_CONFIRM_PASSWORD" type="password" id="setup-forgot-pass-field-password-confirm">
		<label class="input-label">Подтверждение пароля</label>
	</div>
	<div class="form-login__btns">
		<button class="login-btn register-btn active-btn" type="submit" name="change_pwd">Сменить пароль</button>
	</div>
</form>