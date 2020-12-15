<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<!-- DaData -->
<link href="//cdn.jsdelivr.net/npm/suggestions-jquery@19.2.0/dist/css/suggestions.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/suggestions-jquery@19.2.0/dist/js/jquery.suggestions.min.js"></script>

<?global $USER;?>


<!-- add adress popup -->
<div class="popup-layout add-adress-popup__layout">
	<div class="popup add-adress-popup">
		<div class="popup-close">
			<img class="popup-close-icon" src="<?=SITE_TEMPLATE_PATH?>/img/close.svg">
		</div>
		<div class="popup-inner">
			<h2 class="popup-header">Добавить новый адрес</h2>
			<form action="/personal/addresses.php" class="add-adress-form form-validate js-address-add-form"
			      id="address_add_form">
				<input type="hidden" name="mode" value="new">
				<input type="hidden" name="profile" value="">
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="name" type="text" data-num="0">
						<label class="input-label" for="">Название</label>
					</div>
				</div>
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="city" type="text" required="" data-num="1">
						<label class="input-label" for="">Город</label>
					</div>
				</div>
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="index" type="text" data-num="2">
						<label class="input-label" for="">Индекс</label>
					</div>
				</div>
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="street" type="text" required="" data-num="3">
						<label class="input-label" for="">Улица</label>
					</div>
				</div>
				<div class="adress-input double-input">
					<div class="login-input">
						<input class="input" name="house" type="text" required="" data-num="4">
						<label class="input-label" for="">Дом</label>
					</div>
					<div class="login-input">
						<input class="input" name="flat" type="text" data-num="5">
						<label class="input-label" for="">Квартира/офис</label>
					</div>
				</div>
				<button class="blue-btn adress-btn" type="submit">Сохранить</button>
			</form>
		</div>
	</div>
</div>

<!-- change adress popup -->
<div class="popup-layout change-adress-popup__layout">
	<div class="popup change-adress-popup">
		<div class="popup-close">
			<img class="popup-close-icon" src="<?=SITE_TEMPLATE_PATH?>/img/close.svg">
		</div>
		<div class="popup-inner">
			<h2 class="popup-header">Изменить адрес</h2>
			<form action="/personal/addresses.php" class="change-adress-form form-validate js-address-edit-form"
			      id="address_edit_form">
				<input type="hidden" name="mode" value="edit">
				<input type="hidden" name="profile" value="">
				<input type="hidden" name="addr_id" value="">
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="name" type="text" data-num="0">
						<label class="input-label" for="">Название</label>
					</div>
				</div>
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="city" type="text" required="" data-num="2">
						<label class="input-label" for="">Город</label>
					</div>
				</div>
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="index" type="text" data-num="1">
						<label class="input-label" for="">Индекс</label>
					</div>
				</div>
				<div class="adress-input">
					<div class="login-input">
						<input class="input" name="street" type="text" required="" data-num="3">
						<label class="input-label" for="">Улица</label>
					</div>
				</div>
				<div class="adress-input double-input">
					<div class="login-input">
						<input class="input" name="house" type="text" required="" data-num="4">
						<label class="input-label" for="">Дом</label>
					</div>
					<div class="login-input">
						<input class="input" name="flat" type="text" data-num="5">
						<label class="input-label" for="">Квартира/офис</label>
					</div>
				</div>
				<button class="blue-btn adress-btn" type="submit">Сохранить</button>
			</form>
		</div>
	</div>
</div>

<!-- add company popup -->
<div class="popup-layout company-popup__layout">
	<div class="popup company-popup">
		<div class="popup-close">
			<img class="popup-close-icon" src="<?=SITE_TEMPLATE_PATH?>/img/close.svg">
		</div>
		<div class="popup-inner">
			<h2 class="popup-header">Добавить компанию </h2>

			<form method="post" action="/personal/profiles.php" enctype="multipart/form-data" class="add-company-form form-validate js-add-company-form">
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="add" value="1" />
				<div class="company-input">
					<div class="login-input">
						<input class="input valid-email mask-inn-organization" name="UF_INN" type="text" required=""
						       autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
						<label class="input-label" for="">ИНН</label>
					</div>
				</div>
				<div class="manual-trigger">Ввести данные вручную </div>
				<div class="c" style="display: none">Ввести данные автоматически</div>
				<div class="manual-enter" style="display: none;">
					<div class="adress-input double-input">
						<div class="login-input">
							<input class="input valid-email mask-kpp" name="UF_KPP" type="text">
							<label class="input-label" for="">КПП</label>
						</div>
						<div class="login-input">
							<input class="input valid-email mask-bik" name="UF_BIK" type="text" required=""
							       autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
							<label class="input-label" for="">БИК</label>
						</div>
					</div>

					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_CORRESPONDENT_ACCOUNT" type="text" required="">
							<label class="input-label" for="">Корреспондентский счет</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email mask-account" name="UF_ACCOUNT" type="text" required="">
							<label class="input-label" for="">Расчетный счет</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_BANK_NAME" type="text" required="">
							<label class="input-label" for="">Наименование банка</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_BANK_ADDRESS" type="text" required="">
							<label class="input-label" for="">Адрес банка</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_NAME" type="text" required="">
							<label class="input-label" for="">Наименование юридического лица</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_URADDRESS" type="text" required="">
							<label class="input-label" for="">Юридическое адрес</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_POSTADDRESS" type="text">
							<label class="input-label" for="">Почтовый адрес</label>
						</div>
					</div>
					<div class="company-input">
						<div class="login-input">
							<input class="input valid-email" name="UF_PHONE" type="text" required="">
							<label class="input-label" for="">Телефон организации</label>
						</div>
					</div>

					<button class="blue-btn company-btn" type="submit">Сохранить</button>
				</div>
			</form>
		</div>
	</div>
</div>


<?php ob_start() ?>
<!-- change company popup -->
<div class="popup-layout change-company__layout js-popup-change-company">
	<div class="popup change-company__popup">
		<div class="popup-close">
			<img class="popup-close-icon" src="<?=SITE_TEMPLATE_PATH?>/img/close.svg">
		</div>
		<div class="popup-inner">

		</div>
	</div>
</div>

<!-- phone saved popup -->
<div class="popup-layout success-phone__layout">
	<div class="popup success-popup">
		<div class="popup-inner success-popup__inner">
			<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/success.svg" alt="">
			<h2 class="popup-header">Телефон сохранен</h2>
		</div>
	</div>
</div>

<!-- password saved popup -->
<div class="popup-layout success-password__layout <?=($arResult['FORM']['PASSWORD_CHANGED']) ? 'activ-popup' : ''?>">
	<div class="popup success-popup">
		<div class="popup-inner success-popup__inner">
			<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/success.svg" alt="">
			<h2 class="popup-header">Пароль сохранен</h2>
		</div>
	</div>
</div>
<!-- Popups end -->

<?php
$APPLICATION->AddViewContent('popups', ob_get_clean());
?>



<article>
	<h2 class="page-header">
		Личный кабинет
	</h2>

	<div class="lk">
		<div class="lk-content">
			<div class="lk-menu">
				<div class="lk-menu__inner">
					<div class="lk-menu__main">
						<div class="lk-menu__item tab menu-item__active" data-tab-id="#profile">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/profile.svg" alt="">
							<p>Мой профиль</p>
						</div>
						<div class="lk-menu__item tab" data-tab-id="#orders">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="">
							<p>Мои заказы</p>
						</div>
						<div class="lk-menu__item tab" data-tab-id="#buy">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/buy.svg" alt="">
							<p>Мои покупки</p>
						</div>
                        <?php if(count($arResult['USER_PROFILES']) > 1): ?>
						<div class="lk-menu__item tab" data-tab-id="#sale">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/sale.svg" alt="">
							<p>Мои скидки</p>
						</div>
						<?php endif; ?>
						<div class="lk-menu__item tab" data-tab-id="#document">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/document.svg" alt="">
							<p>Запрос документов</p>
						</div>
						<div class="lk-menu__item tab" data-tab-id="#delivery">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/delivery.svg" alt="">
							<p>Адреса доставки</p>
						</div>
						<div class="lk-menu__item tab" data-tab-id="#manager">
							<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/manager.svg" alt="">
							<p>Мой менеджер</p>
						</div>
					</div>
					<a href="/?logout=yes" class="lk-menu__item">
						<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/exit.svg" alt="">
						<p>Выйти</p>
					</a>
				</div>
			</div>
			<div class="lk-info__wrap">
				<div class="lk-info lk-profile lk-info__active">
					<div class="lk-info__col info-col__left">
						<div class="section-header">
							Физическое лицо
						</div>
						<div class="lk-phiz">
							<div class="small-header">Учетная запись</div>
							<div class="lk-info__account">
                                <?php
                                $sPhone = $arResult["arUser"]["~PERSONAL_PHONE"];
                                if (!empty($sPhone)) {
                                	$sPhone = preg_replace('/[^0-9]/', '', $sPhone);
                                    $sPhone = preg_replace('/^8/', '7', $sPhone);
                                    $sPhone = sprintf("+%s (%s) %s-%s-%s",
                                        substr($sPhone, 0, 1),
                                        substr($sPhone, 1, 3),
                                        substr($sPhone, 4, 3),
                                        substr($sPhone, 7, 2),
                                        substr($sPhone, 9)
                                    );
                                }
                                ?>
								<div class="info-account__row account-number__current">
									<div class="info-account__col info-prop">Телефон</div>
									<div class="info-account__col info-val ">
										<?= (!empty($arResult["arUser"]["~PERSONAL_PHONE"])) ? $sPhone : '—' ?>
                                        <?if(empty($arResult["arUser"]["~PERSONAL_PHONE"])):?>
	                                        <span class="confirm-num-fast js-lk-add-phone-btn">Добавить</span>
                                        <?else:?>
                                            <?if(empty($arResult['arUser']['UF_PHONE_CONFIRM'])):?>
		                                        <span class="confirm-num-fast js-lk-confirm-phone-btn">Подтвердить</span>
                                            <?endif?>
                                        <?endif?>
									</div>
									<div class="info-account__col info-change change-number">Изменить</div>
								</div>

								<div class="info-account__row account-number__change hide-account-elem">
									<div class="info-account__col info-prop">Телефон</div>
									<div class="info-account__col info-val account-input__wrap">
										<form id="personal-change-phone">
											<input type="hidden" name="action" value="change_phone">
											<input type="hidden" name="step" value="send_code">
											<div class="phone-change">
												<input type="text" class="input account-input account-number__input" name="phone" value="<?= $sPhone ?>">
												<button class="send-code"
												        type="submit"
												        style="background: #fff;border: 0;font-weight: bold;">Отправить код подтверждения</button>
											</div>
										</form>
										<form id="personal-change-phone-sms-code" class="sms-wrap">
											<input type="hidden" name="phone" value="">
											<input type="hidden" name="action" value="change_phone">
											<input type="hidden" name="step" value="confirm_code">

											<div style="position: relative">
												<input class="input sms-input" type="tel" maxlength="1" tabindex="1" name="numb1">
												<input class="input sms-input" type="tel" maxlength="1" tabindex="2" name="numb2">
												<input class="input sms-input" type="tel" maxlength="1" tabindex="3" name="numb3">
												<input class="input sms-input" type="tel" maxlength="1" tabindex="4" name="numb4">
												<input class="input sms-input" type="tel" maxlength="1" tabindex="5" name="numb5">
											</div>
											<div class="send-again">Отправить код повторно</div>
											<button class="login-btn active-btn save-phone" type="submit" style="margin-top: 20px">Сохранить</button>
										</form>
									</div>
									<div class="info-account__col info-change regect-number">Отменить</div>
								</div>

                                <?php if(empty($arResult['arUser']['EXTERNAL_AUTH_ID']) || $arResult['arUser']['EXTERNAL_AUTH_ID'] != 'socservices'): ?>
									<div class="info-account__row account-password__current">
										<div class="info-account__col info-prop">Пароль</div>
										<div class="info-account__col info-val">***********</div>
										<div class="info-account__col info-change change-password">Изменить</div>
									</div>
									<div class="info-account__row account-password__change hide-account-elem">
										<form id="PERSONAL_CHANGE_PASSWORD" method="post" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
	                                        <?= $arResult["BX_SESSION_CHECK"] ?>
											<input type="hidden" name="lang" value="<?=LANG?>" />
											<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

											<div class="info-account__row">
												<div class="info-account__col info-prop">Новый пароль</div>
												<div class="info-account__col info-val account-input__wrap" style="position: relative">
													<input type="password"
													       name="NEW_PASSWORD"
													       autocomplete="off"
													       id="setup-pass-field-password2"
													       class="input account-input account-password__input account-password__old">
												</div>
												<div class="info-account__col info-change regect-password">Отменить</div>
											</div>

											<div class="info-account__row">
												<div class="info-account__col info-prop">Подтвердить</div>
												<div class="info-account__col info-val account-input__wrap" style="position: relative">
													<input type="password"
													       name="NEW_PASSWORD_CONFIRM"
													       autocomplete="off"
													       class="input account-input account-password__input account-password__old">
												</div>
											</div>
											<div class="info-account__row">
												<div class="info-account__col info-prop"></div>
												<div class="info-account__col pswrd-btn">
													<input type="hidden" name="save" value="SAVE">
													<button class="login-btn active-btn save-pswrd"
													        type="submit">Сохранить</button>
												</div>
											</div>
										</form>
									</div>
								<?php endif; ?>
							</div>

							<div class="small-header">Личные данные</div>
							<div class="lk-info__personal">
								<div class="info-personal__row">
									<div class="info-personal__col personal-prop">Фамилия</div>
									<div class="info-personal__col personal-val"><?=$arResult["arUser"]["~LAST_NAME"]?></div>
								</div>
								<div class="info-personal__row">
									<div class="info-personal__col personal-prop">Имя</div>
									<div class="info-personal__col personal-val"><?=$arResult["arUser"]["~NAME"]?></div>
								</div>
								<div class="info-personal__row">
									<div class="info-personal__col personal-prop">Отчество</div>
									<div class="info-personal__col personal-val"><?=$arResult["arUser"]["~SECOND_NAME"]?></div>
								</div>
								<div class="info-personal__row">
									<div class="info-personal__col personal-prop">Email</div>
									<div class="info-personal__col personal-val"><?=$arResult["arUser"]["~EMAIL"]?></div>
								</div>
								<div class="info-personal__row">
									<div class="info-personal__col personal-prop">Дата рождения</div>
									<div class="info-personal__col personal-val"><?=$arResult["arUser"]["~PERSONAL_BIRTHDAY"]?></div>
								</div>
								<div class="info-personal__row">
									<p class="personal-change">Изменить личные данные</p>
								</div>
							</div>
							<form id="PERSONAL_CHANGE_DATA" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data" class="lk-personal__change">
                                <?=$arResult["BX_SESSION_CHECK"]?>
								<input type="hidden" name="lang" value="<?=LANG?>" />
								<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

								<div class="personal-change__row">
									<div class="lk-personal__col">
										Фамилия
									</div>
									<div class="lk-personal__col">
										<input type="text" name="LAST_NAME" class="input lk-personal__input" value="<?=$arResult["arUser"]["~LAST_NAME"]?>">
									</div>
								</div>
								<div class="personal-change__row">
									<div class="lk-personal__col">
										Имя
									</div>
									<div class="lk-personal__col">
										<input type="text" name="NAME" class="input lk-personal__input" value="<?=$arResult["arUser"]["~NAME"]?>">
									</div>
								</div>
								<div class="personal-change__row">
									<div class="lk-personal__col">
										Отчество
									</div>
									<div class="lk-personal__col">
										<input type="text" name="SECOND_NAME" class="input lk-personal__input" value="<?=$arResult["arUser"]["~SECOND_NAME"]?>">
									</div>
								</div>
								<div class="personal-change__row">
									<div class="lk-personal__col">
										Email
									</div>
									<div class="lk-personal__col">
										<input type="text" class="input lk-personal__input" disabled placeholder="<?=$arResult["arUser"]["~EMAIL"]?>">
									</div>
								</div>
								<div class="personal-change__row">
									<div class="lk-personal__col">
										Дата рождения
									</div>
									<div class="lk-personal__col">
										<input type="text" id="date" name="PERSONAL_BIRTHDAY" class="input lk-personal__input datepicker" value="<?=$arResult["arUser"]["~PERSONAL_BIRTHDAY"]?>">
									</div>
								</div>
								<div class="personal-change__row">
									<div class="lk-personal__col lk-signin">
										Подписка на рассылку
									</div>
									<div class="lk-personal__col lk-signin__confirmation">
										<div class="lk-confirmation__item <?=($arResult["SUBSCRIBE"]) ? 'active-confirmation': ''?>" data-value="Y">Да</div>
										<div class="lk-confirmation__item <?=(!$arResult["SUBSCRIBE"]) ? 'active-confirmation': ''?>" data-value="N">Нет</div>
										<input type="hidden" name="SUBSCRIBE" value="<?=($arResult["SUBSCRIBE"]) ? 'Y': 'N'?>">
									</div>

								</div>
								<div class="personal-change__row">
									<div class="lk-personal__col"></div>
									<div class="lk-personal__col personal-data-btns">
										<input type="hidden" name="save" value="SAVE">
										<button class="login-btn active-btn save-personal-data" type="submit">Сохранить</button>
										<div class="reject-personal-data regect-personal-data">Отмена</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="lk-info__col info-col__right">
						<div class="section-header">
							Юридические лица
						</div>
                        <?$APPLICATION->IncludeComponent(
                            "custom:sale.personal.profile.list",
                            ".default",
                            array(
                                "PATH_TO_DETAIL" => "",
                                "PER_PAGE" => "5",
                                "SET_TITLE" => "N",
                                "COMPONENT_TEMPLATE" => ".default",
                                "COMPOSITE_FRAME_MODE" => "A",
                                "COMPOSITE_FRAME_TYPE" => "AUTO"
                            ),
                            false
                        );?>
					</div>
				</div>
				<div class="lk-info">
					<div class="lk-info__orders lk-info__inner lk-info__empty">
	                    <?php
	                    $_REQUEST['show_all'] = "Y";

	                    $APPLICATION->IncludeComponent(
	                        "bitrix:sale.personal.order.list",
	                        ".default",
	                        array(
	                            "COMPONENT_TEMPLATE" => ".default",
	                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
	                            "CACHE_TYPE" => "A",
	                            "CACHE_TIME" => "3600",
	                            "CACHE_GROUPS" => "Y",
	                            "PATH_TO_DETAIL" => "",
	                            "PATH_TO_COPY" => "/personal/cart/",
	                            "PATH_TO_CANCEL" => "",
	                            "PATH_TO_BASKET" => "/personal/cart/",
	                            "ORDERS_PER_PAGE" => "100",
	                            "ID" => $ID,
	                            "SET_TITLE" => "N",
	                            "SAVE_IN_SESSION" => "Y",
	                            "NAV_TEMPLATE" => "",
	                            "HISTORIC_STATUSES" => array(
	                            ),
	                            "STATUS_COLOR_N" => "yellow",
	                            "STATUS_COLOR_P" => "green",
	                            "STATUS_COLOR_F" => "gray",
	                            "STATUS_COLOR_PSEUDO_CANCELLED" => "red",
	                            "PATH_TO_PAYMENT" => "payment.php",
	                            "PATH_TO_CATALOG" => "/catalog/",
	                            "RESTRICT_CHANGE_PAYSYSTEM" => array(
	                                0 => "0",
	                            ),
	                            "REFRESH_PRICES" => "N",
	                            "DEFAULT_SORT" => "STATUS",
	                            "ALLOW_INNER" => "N",
	                            "ONLY_INNER_FULL" => "N",
	                            "COMPOSITE_FRAME_MODE" => "A",
	                            "COMPOSITE_FRAME_TYPE" => "AUTO"
	                        ),
	                        false
	                    );
	                    ?>
					</div>
				</div>
				<div class="lk-info">
					<div class="lk-info__purchase lk-info__inner lk-info__empty">
	                    <? $APPLICATION->IncludeComponent(
	                        "bitrix:sale.personal.order.list",
	                        "youbought",
	                        array(
	                            "COMPONENT_TEMPLATE" => ".default",
	                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
	                            "CACHE_TYPE" => "A",
	                            "CACHE_TIME" => "3600",
	                            "CACHE_GROUPS" => "Y",
	                            "PATH_TO_DETAIL" => "",
	                            "PATH_TO_COPY" => "",
	                            "PATH_TO_CANCEL" => "",
	                            "PATH_TO_BASKET" => "",
	                            "ORDERS_PER_PAGE" => "",
	                            "ID" => $ID,
	                            "SET_TITLE" => "N",
	                            "SAVE_IN_SESSION" => "Y",
	                            "NAV_TEMPLATE" => "",
	                            "HISTORIC_STATUSES" => array(
	                            ),
	                            "STATUS_COLOR_N" => "green",
	                            "STATUS_COLOR_F" => "gray",
	                            "STATUS_COLOR_PSEUDO_CANCELLED" => "red",
	                            "PATH_TO_PAYMENT" => "payment.php",
	                            "PATH_TO_CATALOG" => "/catalog/",
	                            "RESTRICT_CHANGE_PAYSYSTEM" => array(
	                                0 => "N",
	                            ),
	                            "REFRESH_PRICES" => "N",
	                            "DEFAULT_SORT" => "STATUS",
	                            "ALLOW_INNER" => "N",
	                            "ONLY_INNER_FULL" => "N",
	                            "COMPOSITE_FRAME_MODE" => "A",
	                            "COMPOSITE_FRAME_TYPE" => "AUTO",
	                            "STATUS_COLOR_B" => "gray"
	                        ),
	                        false
	                    );?>
					</div>
				</div>

                <?php if(count($arResult['USER_PROFILES']) > 1): ?>
					<div class="lk-info">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:sale.personal.order.list",
                            "yourdiscount",
                            [
                                "COMPONENT_TEMPLATE" => "yourdiscount",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600",
                                "CACHE_GROUPS" => "Y",
                                "PATH_TO_DETAIL" => "",
                                "PATH_TO_COPY" => "",
                                "PATH_TO_CANCEL" => "",
                                "PATH_TO_BASKET" => "",
                                "ORDERS_PER_PAGE" => "",
                                "ID" => $ID,
                                "SET_TITLE" => "N",
                                "SAVE_IN_SESSION" => "Y",
                                "NAV_TEMPLATE" => "",
                                "HISTORIC_STATUSES" => [
                                ],
                                "STATUS_COLOR_N" => "green",
                                "STATUS_COLOR_F" => "gray",
                                "STATUS_COLOR_PSEUDO_CANCELLED" => "red",
                                "PATH_TO_PAYMENT" => "payment.php",
                                "PATH_TO_CATALOG" => "/catalog/",
                                "RESTRICT_CHANGE_PAYSYSTEM" => [
                                    0 => "0",
                                ],
                                "REFRESH_PRICES" => "N",
                                "DEFAULT_SORT" => "DATE_INSERT",
                                "ALLOW_INNER" => "N",
                                "ONLY_INNER_FULL" => "N",
                                "COMPOSITE_FRAME_MODE" => "A",
                                "COMPOSITE_FRAME_TYPE" => "AUTO",
                                "STATUS_COLOR_B" => "gray"
                            ],
                            false
                        ); ?>
					</div>
				<?php endif; ?>

				<div class="lk-info">
					<div class="lk-info__docs lk-info__inner js-lk-docs-inner form-validate">
	                    <?php $APPLICATION->IncludeComponent(
	                        "bitrix:form.result.new",
	                        "docs",
	                        [
	                            "CACHE_TIME" => "3600",
	                            "CACHE_TYPE" => "A",
	                            "CHAIN_ITEM_LINK" => "",
	                            "CHAIN_ITEM_TEXT" => "",
	                            "COMPOSITE_FRAME_MODE" => "A",
	                            "COMPOSITE_FRAME_TYPE" => "AUTO",
	                            "EDIT_URL" => "",
	                            "IGNORE_CUSTOM_TEMPLATE" => "N",
	                            "LIST_URL" => "",
	                            "SEF_MODE" => "N",
	                            "SUCCESS_URL" => "",
	                            "USE_EXTENDED_ERRORS" => "N",
	                            "WEB_FORM_ID" => "5",
	                            "COMPONENT_TEMPLATE" => "docs",
	                            "VARIABLE_ALIASES" => [
	                                "WEB_FORM_ID" => "WEB_FORM_ID",
	                                "RESULT_ID" => "RESULT_ID",
	                            ]
	                        ],
	                        false
	                    ); ?>
					</div>
				</div>

				<div class="lk-info lk-shipment-block">
					<div class="lk-info__adresses-wrap">
                    <?php foreach ($arResult['USER_PROFILES'] as $key => $arProfile): ?>
						<div class="lk-info__shipment lk-info__inner">
							<? if (!empty(trim($arProfile['NAME']))): ?>
								<div class="lk-shipment__header">
	                                <?=$arProfile['NAME']?>
								</div>
							<? endif; ?>

                            <?php if(!empty($arProfile['ADDRESSES'])): ?>
								<?php foreach (unserialize($arProfile['ADDRESSES']) as $key1 => $address):
                                    $address = explode(',', $address);
                                    $default_addr = $address[count($address) - 1];
                                    $name = $address[0];
                                    unset($address[count($address) - 1]);
                                    unset($address[0]); ?>
									<div class="shipment-row" id="shipment-row-<?=$key?>-<?=$key1?>">
										<div class="shipment-col">
                                            <? if (!empty($name)): ?>
												<div class="shipment-adress__header"><?=$name?></div>
                                            <?php endif; ?>
											<div class="shipment-adress__info"><?= trim(implode(', ', $address), ', '); ?></div>
										</div>
										<div class="shipment-col">
											<div class="shipment-adress__btns">
												<div class="adress-btn change-adress js-change-address"
												     data-profile="<?=$key?>"
												     data-addr="<?=$key1?>">Изменить</div>
												<div class="adress-btn remove-adress js-remove-address"
												     data-profile="<?=$key?>"
												     data-addr="<?=$key1?>">Удалить</div>
											</div>
											<div class="adress-checkbox">
												<div class="checkbox-item">
													<input class="custom-checkbox js-default-address"
													       name="USER_ADDRESS_<?=$key?>"
													       id="USER_ADDRESS_<?=$key?>_<?=$key1?>"
													       data-profile="<?=$key?>" data-addr="<?=$key1?>"
													       type="radio" <?=($default_addr == 1) ? 'checked' : ''?>>
													<label class="checkbox-label" for="USER_ADDRESS_<?=$key?>_<?=$key1?>">По умолчанию</label>
												</div>
											</div>
										</div>
									</div>
	                            <?php endforeach; ?>
                            <?php endif; ?>

							<div class="add-new add-adress js-add-address" data-profile="<?=$key?>"><span>+</span> Добавить адрес</div>
						</div>
					<?php endforeach; ?>
					</div>
				</div>

				<div class="lk-info">
                    <?php
                    $rsUser = CUser::GetByID($USER->GetID());
                    $arUser = $rsUser->Fetch();
                    if(!empty($arUser['UF_MANAGER'])):
                        $rsManager = CUser::GetList($by="id", $order="asc", array('XML_ID' => $arUser['UF_MANAGER']), array('SELECT' => array('UF_ADDNUM')));
                        $arManager = $rsManager->Fetch(); ?>

						<div class="manager bottom_text text_block">
                            <?if ($arManager['PERSONAL_PHOTO']):
                                echo CFile::ShowImage($arManager["PERSONAL_PHOTO"], 200, 200, "border=0", "", true);
                            else: ?>
								<img src="<?=SITE_TEMPLATE_PATH?>/../.default/images/no-photo.jpg" width="200">
                            <? endif; ?>
							<p id="fio"><b>ФИО: </b><?=$arManager['LAST_NAME']?> <?=$arManager['NAME']?> <?=$arManager['SECOND_NAME']?></p>
							<p id="phone"><b>Телефон: </b>+7 (495) 931-96-31 доб. <?=$arManager['UF_ADDNUM']?></p>
							<p id="mobile"><b>Моб. телефон: </b><?=$arManager['PERSONAL_PHONE']?></p>
							<p id="email"><b>E-mail: </b><?=$arManager['EMAIL']?></p>
						</div>
                    <?php else: ?>
	                    <div class="lk-info__manager lk-info__inner lk-info__empty">
		                    <div class="info-empty__content">
			                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/manager.svg" alt="" class="lk-empty__img">
			                    <div class="info-empty__header">
				                    У вас пока нет менеджера
			                    </div>
		                    </div>
	                    </div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</article>

