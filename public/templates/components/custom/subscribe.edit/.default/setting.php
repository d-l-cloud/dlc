<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>

<?if (!empty($arResult["MESSAGE"]["SENT"])):?>
    <script>window.addEventListener('load', function() {
            ingEvents.Event({category:'forms', action:'submit', label:'subscribe', ya_label:'subscribe', goalParams:{}});
        });</script>
<?endif;?>


<div class="subscribe-col">
	<form action="<?= $arResult["FORM_ACTION"] ?>" class="subscribe-form" method="post">
		<div class="subscribe-form__header">
			<img class="subscribe-img" src="<?=SITE_TEMPLATE_PATH?>/img/subscribe.png">

			<div class="form-header__notification">
				<div class="notification-amount">5</div>
			</div>
		</div>
		<div class="subscribe-form__inner">
			<div class="subscribe-form__text">
				Узнавай первым актуальные скидки и акции
			</div>
			<div class="subscribe-form__confirm">
                <?= bitrix_sessid_post(); ?>

				<div class="subscribe-input">
					<input class="input valid-email"
					       name="EMAIL" type="mail"
					       value="<?= $arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"]; ?>">
					<label class="input-label" for="">Введите ваш email</label>
				</div>
				<div style="display:none" hidden="hidden">
                    <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
						<input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>" checked />
                    <?endforeach;?>
				</div>

				<button type="submit" name="Save">Подписаться</button>

				<input type="hidden" name="FORMAT" value="html" />

				<input type="hidden" name="PostAction" value="<?= ($arResult["ID"] > 0 ? "Update" : "Add") ?>"/>
				<input type="hidden" name="ID" value="<?= $arResult["SUBSCRIPTION"]["ID"]; ?>"/>
                <?php if($_REQUEST["register"] == "YES"): ?>
					<input type="hidden" name="register" value="YES" />
                <?php endif; ?>
                <?php if($_REQUEST["authorize"]=="YES"): ?>
					<input type="hidden" name="authorize" value="YES" />
                <?php endif; ?>
			</div>
		</div>
	</form>
</div>
