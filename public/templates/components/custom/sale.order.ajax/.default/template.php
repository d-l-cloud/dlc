<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
use Local\YadostHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */

CModule::IncludeModule('ipol.yadost');

$obAsset = Main\Page\Asset::getInstance();

$obAsset->addJs('https://api-maps.yandex.ru/2.1/?lang=ru_RU');

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$scheme = $request->isHttps() ? 'https' : 'http';

switch (LANGUAGE_ID) {
    case 'ru':
        $locale = 'ru-RU';
        break;
    case 'ua':
        $locale = 'ru-UA';
        break;
    case 'tk':
        $locale = 'tr-TR';
        break;
    default:
        $locale = 'en-US';
        break;
}

?>
	<NOSCRIPT>
		<div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
	</NOSCRIPT>
<?

if (strlen($request->get('ORDER_ID')) > 0) {
    include(Main\Application::getDocumentRoot() . $templateFolder . '/confirm.php');
} elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET']) {
    include(Main\Application::getDocumentRoot() . $templateFolder . '/empty.php');
} else {
    $hideDelivery = empty($arResult['DELIVERY']);
    $getParams = explode('?', POST_FORM_ACTION_URI);
    if (isset($getParams[1])) {
        $urlString = $getParams[0];
        $getParams = explode('&amp;', $getParams[1]);
        foreach ($getParams as $key => $getParam) {
            if (in_array(explode('=', $getParam)[0], ['COPY', 'EDIT'])) {
                unset($getParams[$key]);
            }
        }
        $urlString .= '?' . implode('&', $getParams);
    }

    $arYaDostOrderData = [
        'WIDTH' => 0,
	    'HEIGHT' => 0,
	    'LENGTH' => 0,
	    'WEIGHT' => $arResult['ORDER_WEIGHT'] / 1000,
	    'ORDER_COST' => $arResult['ORDER_PRICE'],
	    'TOTAL_COST' => $arResult['ORDER_TOTAL_PRICE'],
    ];

    foreach ($arResult['BASKET_ITEMS'] as $basketItem) {
    	$basketItemDims = unserialize($basketItem['~DIMENSIONS']);

    	if (!empty($basketItemDims['WIDTH'])) {
            $arYaDostOrderData['WIDTH'] += ($basketItemDims['WIDTH'] * $basketItem['QUANTITY']) / 10;
	    }

    	if (!empty($basketItemDims['HEIGHT'])) {
            $arYaDostOrderData['HEIGHT'] += ($basketItemDims['HEIGHT'] * $basketItem['QUANTITY']) / 10;
	    }

    	if (!empty($basketItemDims['LENGTH'])) {
            $arYaDostOrderData['LENGTH'] += ($basketItemDims['LENGTH'] * $basketItem['QUANTITY']) / 10;
	    }
    }


    $arDeliveryTypes = [];
    foreach ($arResult['DELIVERY'] as $arDelivery) {
        switch ($arDelivery['ID']) {
            case "2":
                $arDeliveryTypes[] = [
                    'DELIVERY_ID' => $arDelivery['ID'],
                    'NAME' => $arDelivery['NAME'],
                    'MIN_COST_TEXT' => 'Бесплатно',
                    'IMAGE' => SITE_TEMPLATE_PATH . '/img/basket/pickup.svg',
                ];
                break;
            case "8":
            	$arAllTC = YadostHelper::getCourierTariffsByCurrentCity($arYaDostOrderData);

            	foreach ($arAllTC as $arTc) {
					$sIconImageSrc = '';
					$sName = $arTc['delivery']['name'];
					switch ($arTc['delivery']['unique_name']) {
                        case 'PEK':
                            $sName = 'Доставка. ПЭК';
                            $sIconImageSrc = SITE_TEMPLATE_PATH . '/img/basket/logo-pek.svg';
                            break;
                        case 'Boxberry':
                            $sName = 'Доставка. Boxberry';
                            $sIconImageSrc = SITE_TEMPLATE_PATH . '/img/basket/logo-boxberry.svg';
                            break;
                        case 'Beta_Post_Online':
                            break;
					}

                    $arDeliveryTypes[] = [
                        'DELIVERY_ID' => $arDelivery['ID'],
                        'NAME' => $sName,
	                    'DAYS' => $arTc['days'],
	                    'COST' => $arTc['costWithRules'],
                        'MIN_COST_TEXT' => 'От ' . round($arTc['costWithRules'] / 3 * 2) . ' руб',
                        'IMAGE' => $sIconImageSrc,
	                    'FORM_TYPE' => 'ADDRESS_YADOST',
	                    'yd_deliveryData' => json_encode($arTc, true),
	                    'ipol_deliveryPrice' => json_encode([
                            "price" => $arTc['costWithRules'],
                            "term" => $arTc['days'],
                            "provider" => $arTc['delivery']['unique_name'],
                        ], true),
                    ];
	            }

                break;
            case "9":
                $arDeliveryTypes[] = [
                    'DELIVERY_ID' => $arDelivery['ID'],
                    'NAME' => 'Пункты выдачи',
                    'COST' => '',
                    'MIN_COST_TEXT' => '',
                    'IMAGE' => SITE_TEMPLATE_PATH . '/img/basket/pickpoint.svg',
                    'FORM_TYPE' => 'PICKPOINTS_YADOST',
	                'IS_AJAX' => 'Y',
	                'ACTION' => '/ajax/get_yadost_pickpoints.php',
	                'POST_DATA' => json_encode([
                        'ORDER_DATA' => $arYaDostOrderData,
	                ], true),
                ];
                break;
        }
    }
    ?>

	<article>
		<section class="checkout">
			<h1 class="page-header">
				Оформление заказа
			</h1>

			<form class="checkout-wrap" action="<?=isset($urlString) ? $urlString : POST_FORM_ACTION_URI ?>"
			      method="post" name="ORDER_FORM" enctype="multipart/form-data">
				<div class="checkout-col checkout-left">
					<input type="hidden" name="SITE_ID" value="<?=SITE_ID?>">
					<?
                    $signer = new \Bitrix\Main\Security\Sign\Signer;
                    $signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
					?>
					<input type="hidden" name="signedParamsString" value="<?=$signedParams?>">
					<input type="hidden" name="order[sessid]" value="<?=bitrix_sessid()?>">
					<input type="hidden" name="order[soa-action]" value="saveOrderAjax">

					<input type="hidden" name="order[PROFILE_ID]" value="">

                    <?
                    echo bitrix_sessid_post();

                    if (strlen($arResult['PREPAY_ADIT_FIELDS']) > 0) {
                        echo $arResult['PREPAY_ADIT_FIELDS'];
                    }
                    ?>
					<input type="hidden" name="<?= $arParams['ACTION_VARIABLE'] ?>" value="saveOrderAjax">
					<input type="hidden" name="order[location_type]" value="code">
					<input type="hidden" name="order[BUYER_STORE]" id="BUYER_STORE" value="<?= $arResult['BUYER_STORE'] ?>">

					<? if (!$USER->IsAuthorized()): ?>
						<div class="authorize-question">
							Уже зарегистрированы? <span class="checkout-authorize link-blue js-open-login-popup">Авторизоваться</span> или <span class="checkout-register link-blue js-open-login-popup">Зарегистрироваться</span>
							<div class="close">
								<svg width="10" height="10" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L4 2.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L2.58579 4L0.292893 6.29289C-0.0976307 6.68342 -0.0976308 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L4 5.41421L6.29289 7.70711C6.68342 8.09763 7.31658 8.09763 7.70711 7.70711C8.09763 7.31658 8.09763 6.68342 7.70711 6.29289L5.41421 4L7.70711 1.70711Z" fill="#BDBDBD"></path>
								</svg>
							</div>
						</div>
					<? endif; ?>

					<!--
					<div class="delivery-place">
						<div class="delivery-place__wrap">
							<div class="delivery-icon">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/basket/order.svg" alt="">
							</div>
							<div class="delivery-place__current">
								По Москве и Московской области доставим заказ на следующий рабочий день
							</div>
							<span class="tick checkout-tick"></span>
						</div>


						<div class="delivery-place__details">
							<div class="delivery-place__col delivery-place__description">
								<div class="delivery-cost">
                                    <span class="delivery-cost__header">
                                        Стоимость доставки в пределах МКАД:
                                    </span>
									<span class="delivery-cost__bold">300 р.</span> при весе груза до 5 кг. (при заказе свыше <span class="delivery-cost__bold">5 000 р.</span> и весом не больше 3,5 кг. товар доставляется бесплатно в пределах МКАД)
									<span class="delivery-cost__bold">От 2 000 р.</span> при весе груза свыше 5 кг.
								</div>
								<div class="delivery-hint">
									Время доставки и стоимость перевозки груза в регионы можете посмотреть на сайте наших партнеров – транспортной компании <span class="delivery-company-name">«Деловые Линии»</span>
								</div>

							</div>
							<div class="delivery-place__col delivery-col__map">
								<div class="delivery-map__wrap">
									<div class="delivery-map">
										<img src="<?=SITE_TEMPLATE_PATH?>/img/basket/delivery-map.svg" alt="">
										<div class="delivery-map__mark">
											Дорлок
										</div>
									</div>
								</div>
								<div class="delivery-zones">
									<div class="delivery-zones__header">
										Данная схема доставки распространяется на заказы весом свыше 3,5 кг
									</div>
									<div class="delivery-zones__list">
										<div class="zones-list__item">
											<div class="zones-list__color zone-red"></div>
											<div class="zones-list__adress">
												<div class="zones-adress__header">
													Центр
												</div>
												Стоимость доставки <span class="delivery-cost__bold">2 000р.</span>
											</div>
										</div>
										<div class="zones-list__item">
											<div class="zones-list__color zone-orange"></div>
											<div class="zones-list__adress">
												<div class="zones-adress__header">
													Ленинградское шоссе-Щелковское шоссе
												</div>
												Стоимость доставки <span class="delivery-cost__bold">2 000р.</span>
											</div>
										</div>
										<div class="zones-list__item">
											<div class="zones-list__color zone-purple"></div>
											<div class="zones-list__adress">
												<div class="zones-adress__header">
													Щелковское шоссе-Каширское шоссе
												</div>
												Стоимость доставки <span class="delivery-cost__bold">2 000р.</span>
											</div>
										</div>
										<div class="zones-list__item">
											<div class="zones-list__color zone-green"></div>
											<div class="zones-list__adress">
												<div class="zones-adress__header">
													Каширское шоссе-Мажайское шоссе
												</div>
												Стоимость доставки <span class="delivery-cost__bold">1 500р.</span>
											</div>
										</div>
										<div class="zones-list__item">
											<div class="zones-list__color zone-cyan"></div>
											<div class="zones-list__adress">
												<div class="zones-adress__header">
													Мажайское шоссе-Ленинградское шоссе
												</div>
												Стоимость доставки <span class="delivery-cost__bold">2 000р.</span>
											</div>
										</div>
										<div class="delivery-extra">
											При доставке на расстояние более 10 км. от МКАД: <span class="delivery-cost__bold">2 000 р. + 25 р. за каждый км.</span>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					-->

					<div class="checkout-tabs delivery-method">
						<div class="sub-header">
							<div class="sub-header">
								<span class="num">1.</span> Способ и адрес доставки
							</div>
						</div>
						<div class="features delivery-methods__types">
							<? foreach ($arDeliveryTypes as $arDeliveryType): ?>
								<div class="features-item delivery-type"
								     data-delivery-id="<?=$arDeliveryType['DELIVERY_ID']?>"
                                    <?=($arDeliveryType['IS_AJAX'] == 'Y') ? 'data-ajax="Y"' : ''?>
                                    <?=(!empty($arDeliveryType['POST_DATA'])) ? 'data-post-data="'.htmlspecialchars($arDeliveryType['POST_DATA']).'"' : ''?>
                                    <?=(!empty($arDeliveryType['ACTION'])) ? 'data-action="'.$arDeliveryType['ACTION'].'"' : ''?>>
									<div class="delivery-service">
										<div class="delivery-service__img">
											<? if (!empty($arDeliveryType['IMAGE'])): ?>
												<img src="<?=$arDeliveryType['IMAGE']?>">
											<? endif; ?>
										</div>
										<div class="delivery-service__name">
                                            <?=$arDeliveryType['NAME']?>
											<div class="delivery-service__cost"><?=(!empty($arDeliveryType['MIN_COST_TEXT'])) ? $arDeliveryType['MIN_COST_TEXT'] : ''?></div>
										</div>
									</div>
								</div>
							<? endforeach; ?>
						</div>

						<div class="delivery-type__content">
							<? foreach ($arDeliveryTypes as $arDeliveryType):
								$FT = $arDeliveryType['FORM_TYPE'];
								?>
								<div class="delivery-content-wrapper">
									<input type="hidden" name="order[DELIVERY_ID]" value="<?=$arDeliveryType['DELIVERY_ID']?>" disabled>
                                    <? if ($FT == 'ADDRESS_YADOST'): ?>
	                                    <input type="hidden" name="order[yd_is_select]" value="ipolYadost" disabled>
	                                    <input type="hidden" name="order[ipol_deliveryPrice]" value="<?=htmlspecialchars($arDeliveryType['ipol_deliveryPrice'])?>" disabled>
	                                    <input type="hidden" name="order[yd_deliveryData]" value="<?=htmlspecialchars($arDeliveryType['yd_deliveryData'])?>" disabled>
										<div class="delivery-content">
											<div class="delivery-adress js-person-type js-person-type-2">
												<div class="unregistered-city js-location-error">
													Город не зарегистрирован в системе. Просьба обратиться к менеджеру для оформления заказа.
												</div>

												<div class="delivery-adress__inner">
													<div class="delivery-adress__header">
														Адрес доставки
													</div>
													<div class="my-adresses js-open-addresses-popup" data-addresses="">
														Мои адреса
													</div>
													<div class="my-adresses js-open-addresses-page" style="display: none">
														<a href="/personal/">Добавьте адреса</a>
													</div>

													<input type="hidden" name="order[ORDER_PROP_37]" value="">

													<input type="hidden" name="order[ORDER_PROP_64]" value="<?=$_COOKIE['header_city_code']?>">
													<div class="login-input delivery-input js-current-city" data-type="checkout">
														<input class="input disabled" type="text" disabled value="<?=$_COOKIE['header_city']?>" style="cursor: pointer">
														<label class="input-label" for="">Город</label>
													</div>
													<div class="login-input delivery-input">
														<input class="input" name="order[ORDER_PROP_40]" type="text" required disabled>
														<label class="input-label" for="">Улица</label>
													</div>
													<div class="double-input">
														<div class="login-input delivery-input delivery-double-input">
															<input class="input" name="order[ORDER_PROP_41]" type="text" disabled>
															<label class="input-label" for="">Дом</label>
														</div>
														<div class="login-input delivery-input delivery-double-input">
															<input class="input" name="order[ORDER_PROP_42]" type="text" disabled>
															<label class="input-label" for="">Квартира/офис</label>
														</div>
													</div>
													<div class="delivery-dateprice delivery-dateprice__active">
														<div class="delivery-date"><?= $arDeliveryType['DAYS'] ?> дн.</div>
														<div class="delivery-price js-delivery-cost"><?= $arDeliveryType['COST'] ?> руб</div>
													</div>
												</div>
											</div>
											<div class="delivery-adress js-person-type js-person-type-1" style="display: none">
												<div class="unregistered-city js-location-error">
													Город не зарегистрирован в системе. Просьба обратиться к менеджеру для оформления заказа.
												</div>
												<div class="delivery-adress__inner">
													<div class="delivery-adress__header">
														Адрес доставки
													</div>
													<div class="my-adresses js-open-addresses-popup" data-addresses="">
														Мои адреса
													</div>
													<div class="my-adresses js-open-addresses-page" style="display: none">
														<a href="/personal/">Добавьте адреса</a>
													</div>

													<input class="disabled-person" type="hidden" name="order[ORDER_PROP_34]" value="" disabled>

													<input class="disabled-person" type="hidden" name="order[ORDER_PROP_65]" value="<?=$_COOKIE['header_city_code']?>" disabled>

													<div class="login-input delivery-input js-current-city" data-type="checkout">
														<input class="input disabled disabled-person" type="text" disabled
														       value="<?=$_COOKIE['header_city']?>" style="cursor: pointer">
														<label class="input-label" for="">Город</label>
													</div>
													<div class="login-input delivery-input">
														<input class="input disabled-person" name="order[ORDER_PROP_56]" type="text" required disabled>
														<label class="input-label" for="">Улица</label>
													</div>
													<div class="double-input">
														<div class="login-input delivery-input delivery-double-input">
															<input class="input disabled-person" name="order[ORDER_PROP_57]" type="text" disabled>
															<label class="input-label" for="">Дом</label>
														</div>
														<div class="login-input delivery-input delivery-double-input">
															<input class="input disabled-person" name="order[ORDER_PROP_58]" type="text" disabled>
															<label class="input-label" for="">Квартира/офис</label>
														</div>
													</div>
													<div class="login-input delivery-input">
														<input class="input disabled-person" name="order[ORDER_PROP_59]" type="text" disabled>
														<label class="input-label" for="">Индекс</label>
													</div>
													<div class="delivery-dateprice delivery-dateprice__active">
														<div class="delivery-date"><?= $arDeliveryType['DAYS'] ?> дн.</div>
														<div class="delivery-price js-delivery-cost"><?= $arDeliveryType['COST'] ?> руб</div>
													</div>
												</div>
											</div>
										</div>
									<? elseif ($FT == 'PICKPOINTS_YADOST'): ?>
	                                    <input type="hidden" name="order[yd_is_select]" value="ipolYadost" disabled>
	                                    <input type="hidden" name="order[yd_deliveryData]" value="" disabled>
	                                    <input type="hidden" name="order[yd_ajaxDeliveryPrice]" value="" disabled>
	                                    <input type="hidden" name="order[yd_pvzAddressValue]" value="" disabled>
										<div class="delivery-content delivery-content__map"></div>
									<? endif; ?>
								</div>
							<? endforeach; ?>
						</div>
					</div>
					<div class="checkout-tabs payment-method">
						<div class="sub-header">
							<span class="num">2.</span> Способ оплаты
						</div>
						<div class="features checkout-payment-type">
							<? foreach ($arResult['PAY_SYSTEM'] as $arPaySystem):
								$sImg = '';
								switch ($arPaySystem['ID']) {
									case 8:
                                        $sImg = SITE_TEMPLATE_PATH . '/img/basket/card.svg';
										break;
									case 3:
                                        $sImg = SITE_TEMPLATE_PATH . '/img/basket/score.svg';
										break;
									case 9:
                                        $sImg = SITE_TEMPLATE_PATH . '/img/basket/pickpoint.svg';
										break;
                                }
								?>
								<div class="features-item" data-pay-system-id="<?=$arPaySystem['ID']?>">
									<div class="delivery-service">
										<div class="delivery-service__img">
											<img src="<?=$sImg?>" alt="">
										</div>
										<div class="delivery-service__name">
											<?=$arPaySystem['NAME']?>
										</div>

									</div>
								</div>
							<? endforeach; ?>
						</div>
						<input type="hidden" name="order[PAY_SYSTEM_ID]">
					</div>

					<div class="customer-info">
						<div class="sub-header">
							<span class="num">3.</span> Данные покупателя
						</div>

						<div class="form checkout-customer-form">
							<? if ($USER->IsAuthorized()): ?>
								<div class="customer-data__double customer-data__double-active">
									<div class="features-item features-active customer-type" data-person-type="2">
										<div class="customer-type__item">
											Физическое лицо
										</div>
									</div>
									<div class="features-item customer-type" data-person-type="1">
										<div class="customer-type__item">
											Юридическое лицо
										</div>
									</div>
								</div>
							<? endif; ?>
							<div class="customer-data__content">
								<?
								$bDisableInput = false;
								if ($USER->IsAuthorized()) {
                                    $bDisableInput = true;
								} ?>
								<div class="customer-data__item customer-content__active">
									<input type="hidden" name="order[PERSON_TYPE]" value="2">
									<div class="login-input">
										<input class="input <?=($bDisableInput) ? 'disabled' : ''?>"
										       name="order[ORDER_PROP_19]" value="<?=$arResult['ORDER_DATA']['ORDER_PROP'][19]?>"
										       type="text" <?=($bDisableInput) ? 'disabled' : ''?>>
										<label class="input-label" for="">Фамилия</label>
									</div>
									<div class="login-input">
										<input class="input <?=($bDisableInput) ? 'disabled' : ''?>"
										       name="order[ORDER_PROP_20]" value="<?=$arResult['ORDER_DATA']['ORDER_PROP'][20]?>"
										       type="text" <?=($bDisableInput) ? 'disabled' : ''?>>
										<label class="input-label" for="">Имя</label>
									</div>
									<div class="login-input">
										<input class="input <?=($bDisableInput) ? 'disabled' : ''?>"
										       name="order[ORDER_PROP_21]" value="<?=$arResult['ORDER_DATA']['ORDER_PROP'][21]?>"
										       type="text" <?=($bDisableInput) ? 'disabled' : ''?>>
										<label class="input-label" for="">Отчество</label>
									</div>
									<div class="login-input">
										<input class="input valid-phone <?=($bDisableInput) ? 'disabled' : ''?>"
										       name="order[ORDER_PROP_22]" value="<?=$arResult['ORDER_DATA']['ORDER_PROP'][22]?>"
										       type="tel" <?=($bDisableInput) ? 'disabled' : ''?> required>
										<label class="input-label" for="">Телефон</label>
									</div>
									<div class="login-input">
										<input class="input login-email <?=($bDisableInput) ? 'disabled' : ''?>"
										       name="order[ORDER_PROP_23]" value="<?=$arResult['ORDER_DATA']['ORDER_PROP'][23]?>"
										       type="email" <?=($bDisableInput) ? 'disabled' : ''?> required>
										<label class="input-label" for="">Email</label>
									</div>
									<div style="position:relative;">
										<div class="checkbox-item">
											<input id="order-agree-1" class="custom-checkbox" name="order[agree]" type="checkbox" value="Y" required>
											<label class="checkbox-label" for="order-agree-1">С &nbsp;<a href="/politika-konfidentsialnosti/" class="link-blue" target="_blank">условиями обработки данных</a>&nbsp; ознакомлен и согласен</label>
										</div>
									</div>
									<textarea name="order[ORDER_DESCRIPTION]" cols="30" rows="5"
									          class="textarea" placeholder="Комментарий к заказу"></textarea>
								</div>
								<div class="customer-data__item">
									<input type="hidden" name="order[PERSON_TYPE]" value="1" disabled>
									<div class="checkout-entity">
										<div class="change-company-form form-validate" novalidate="novalidate">
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input mask-inn-organization disabled" name="order[ORDER_PROP_6]" type="text" disabled>
													<label class="input-label" for="">ИНН</label>
												</div>
											</div>

											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_53]" type="text" disabled>
													<label class="input-label" for="">Корреспондентский счет</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input mask-account disabled" name="order[ORDER_PROP_52]" type="text" disabled>
													<label class="input-label" for="">Расчетный счет</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_50]" type="text" disabled>
													<label class="input-label" for="">Наименование банка</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_54]" type="text" disabled>
													<label class="input-label" for="">Адрес банка</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_7]" type="text" disabled>
													<label class="input-label" for="">Наименование юридического лица</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_9]" type="text" disabled>
													<label class="input-label" for="">Юридический адрес</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_10]" type="text" disabled>
													<label class="input-label" for="">Почтовый адрес</label>
												</div>
											</div>
											<div class="checkout-entity-input">
												<div class="login-input">
													<input class="input disabled" name="order[ORDER_PROP_11]" type="text" disabled>
													<label class="input-label" for="">Телефон организации</label>
												</div>
											</div>

											<div class="checkout-entity__double double-input">
												<div class="login-input">
													<input class="input mask-kpp disabled" name="order[ORDER_PROP_8]" type="text" disabled>
													<label class="input-label" for="">КПП</label>
												</div>
												<div class="login-input">
													<input class="input mask-bik disabled" name="order[ORDER_PROP_51]" type="text" disabled>
													<label class="input-label" for="">БИК</label>
												</div>
											</div>
											<div style="position:relative;">
												<div class="checkbox-item">
													<input id="order-agree-2" class="custom-checkbox" name="order[agree]" type="checkbox" value="Y" required disabled>
													<label class="checkbox-label" for="order-agree-2">С &nbsp;<a href="/politika-konfidentsialnosti/" class="link-blue" target="_blank">условиями обработки данных</a>&nbsp; ознакомлен и согласен</label>
												</div>
											</div>

											<textarea name="order[ORDER_DESCRIPTION]" cols="30" rows="5"
											          class="textarea" placeholder="Комментарий к заказу" disabled></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="checkout-col checkout-right">
					<div class="basket-total">
						<div class="total-row not-edit">
							<div class="total-col">
								<div class="total-goods">
                                    <?
                                    $normalCount = count($arResult['BASKET_ITEMS']);
                                    echo $normalCount . ' ' . wordCountEndings($normalCount, 'товар', 'товара', 'товаров');
                                    ?>
								</div>
							</div>
							<div class="total-col">
								<div class="total-weight">
									<?= $arResult['ORDER_WEIGHT_FORMATED'] ?>
								</div>
							</div>
						</div>
						<?
							$arOrderFields = [];
                            $arOrderFields[] = [
                                'CODE' => 'SUM',
                                'VISIBLE' => true,
                                'LABEL' => 'Сумма',
                                'TYPE' => 'sum',
                                'VALUE' => $arResult['PRICE_WITHOUT_DISCOUNT'],
                            ];

	                        $arOrderFields[] = [
                                'CODE' => 'DISCOUNT',
                                'VISIBLE' => ($arResult['DISCOUNT_PRICE'] > 0),
	                            'LABEL' => 'Скидка',
	                            'TYPE' => 'discount',
	                            'VALUE' => '-' . $arResult['DISCOUNT_PRICE_FORMATED'],
	                        ];

	                        $arOrderFields[] = [
                                'CODE' => 'DELIVERY',
                                'VISIBLE' => false,
	                            'LABEL' => 'Доставка',
	                            'TYPE' => 'sum',
	                            'VALUE' => $arResult['DELIVERY_PRICE_FORMATED'],
	                        ];
						?>
						<? foreach ($arOrderFields as $key => $arOrderField):
                            $bLastKey = false;
							if (count($arOrderFields) - 1 == $key) {
								$bLastKey = true;
                            }
							?>
							<div class="total-row table-row-<?=$arOrderField['CODE']?> <?=($bLastKey) ? 'row-border' : ''?>"
								 <?=($arOrderField['VISIBLE']) ? '' : 'style="display:none;"'?>>
								<div class="total-col">
									<div class="total-val">
	                                    <?=$arOrderField['LABEL']?>
									</div>
								</div>
								<div class="total-col">
									<div class="total-<?=$arOrderField['TYPE']?> js-total-value">
										<?=$arOrderField['VALUE']?>
									</div>
								</div>
							</div>
						<? endforeach; ?>

						<div class="total-row table-row-TOTAL row-result">
							<div class="total-col">
								<div class="total-val">
									Общая стоимость
								</div>
							</div>
							<div class="total-col">
								<div class="total-result js-total-value">
									<?=$arResult['ORDER_TOTAL_PRICE_FORMATED']?>
								</div>
							</div>
						</div>

						<button type="submit" class="basket-checkout-btn checkout-btn">
							Оформить заказ
						</button>
					</div>
				</div>
			</form>
		</section>
	</article>
<?
}
?>