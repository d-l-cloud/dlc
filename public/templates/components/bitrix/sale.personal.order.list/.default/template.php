<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main,
Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<?if(!empty($arResult['ERRORS']['FATAL'])):?>

    <?foreach($arResult['ERRORS']['FATAL'] as $error):?>
        <?=ShowError($error)?>
    <?endforeach?>

<?else:?>

    <?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

        <?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
            <?=ShowError($error)?>
        <?endforeach?>

    <?endif?>

    <?if(!empty($arResult['ORDERS'])):?>
		<div class="orders__wrap">
			<div class="orders-list">
                <div class="orders-row orders-row__header">
                    <div class="orders-col orders-col__header">Номер заказа</div>
                    <div class="orders-col orders-col__header">Дата оформления</div>
                    <div class="orders-col orders-col__header">Сумма</div>
                    <div class="orders-col orders-col__header">Статус</div>
                    <div class="orders-col orders-col__header">Юр. лицо</div>
                </div>
				<?foreach($arResult["ORDERS"] as $key => $order):?>
	                <div class="orders-row orders-item js-lk-order-item" data-order-id=<?=$order['ORDER']['ID']?>>
	                    <div class="orders-col"><?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
	                        <?if (empty($order['PROPERTIES']['UF_CREATED_BY_1C']) || $order['PROPERTIES']['UF_CREATED_BY_1C'] == 'N'):?>
			                    (через сайт)
	                        <?else:?>
			                    (через менеджера)
	                        <?endif?>
	                    </div>
	                    <div class="orders-col">
	                        <?if(!empty($order['PROPERTIES']['UF_DATE_CREATED_1C_FORMATED'])):?>
	                            <?=$order['PROPERTIES']['UF_DATE_CREATED_1C_FORMATED']?>
	                        <?else:?>
	                            <?=$order["ORDER"]["DATE_INSERT_FORMATED"]?>
	                        <?endif?>
	                    </div>
	                    <div class="orders-col"><?=$order["ORDER"]["FORMATED_PRICE"]?></div>
	                    <div class="orders-col">
	                        <?if($order["ORDER"]["CANCELED"] == 'N') {
	                            if($order["ORDER"]["STATUS_ID"] == 'N'){?>
	                                <?=$arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["NAME"]?>
		                            <div class="regect-order js-order-cancel">Отменить заказ</div>
	                            <?} else {?>
	                                <?=$arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["NAME"]?>
	                            <?}
	                        } else{ ?>
			                    Отменен
	                        <?}?>
	                    </div>
	                    <div class="orders-col">
	                        <?if(!empty($order['PROPERTIES']['UF_NAME'])):?>
	                            <?=$order['PROPERTIES']['UF_NAME']?>
	                        <?endif?>
	                    </div>
	                </div>
                <?endforeach;?>
            </div>

			<?foreach($arResult["ORDERS"] as $key => $order):?>
				<div class="orders-detail order-detail-<?=$order['ORDER']['ID']?>">
					<div class="orders-detail__header">
						<h2 class="section-header">Заказ №<?=$order['ORDER']['ACCOUNT_NUMBER']?> от
                            <?if(!empty($order['PROPERTIES']['UF_DATE_CREATED_1C_FORMATED'])):?>
                                <?=$order['PROPERTIES']['UF_DATE_CREATED_1C_FORMATED']?>
                            <?else:?>
                                <?=$order["ORDER"]["DATE_INSERT_FORMATED"]?>
                            <?endif?>
						</h2>
						<span class="order-completed__true"><?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$order['ORDER']['STATUS_ID']]['NAME'])?> от <?=$order['ORDER']['DATE_STATUS_FORMATED']?></span>
					</div>

					<div class="order-detail-table">
						<div class="order-consist">
							<div class="orders-row orders-row__header">
								<div class="orders-col orders-col__header orders-col__num">№</div>
								<div class="orders-col orders-col__header">Наименование товара</div>
								<div class="orders-col orders-col__header">Цена</div>
								<div class="orders-col orders-col__header ">Количество</div>
								<div class="orders-col orders-col__header">Сумма</div>
							</div>
							<?	if (CModule::IncludeModule("catalog")):
                                $i = 0;
                                $totalBasketSum = 0;
                                foreach ($order["BASKET_ITEMS"] as $item):
                                    $i++;
                                    $id = $item["PRODUCT_ID"];
                                    $img = $name = $article = '';

                                    $arSelect = ["ID", "NAME", "PROPERTY_CML2_ARTICLE"];
                                    $arFilter = ["ID" => $id];
                                    $res = CIBlockElement::GetList([], $arFilter, false, ["nPageSize" => 1], $arSelect);
                                    if ($ob = $res->GetNextElement()) {
                                        $arFields = $ob->GetFields();
                                        $name = $arFields['NAME'];
                                        $article = $arFields["PROPERTY_CML2_ARTICLE_VALUE"];
                                    } ?>
	                                <div class="order-consist__item">
									<div class="orders-row orders-item">
										<div class="orders-col orders-col__num"><?=$i?></div>
										<div class="orders-col">
                                            <?if(!empty($name)):?>
												<a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$name?></a>
                                            <?else:?>
                                                <?=$item['NAME']?>
                                            <?endif?>
											<br/>
											<span class="order-articul">Артикул <?=$article?></span>
										</div>
										<div class="orders-col"><?=CurrencyFormat($item["PRICE"], "RUB");?></div>
                                        <?$totalBasketSum += $item["PRICE"] * $item['QUANTITY']?>
										<div class="orders-col "><?=$item['QUANTITY']?></div>
										<div class="orders-col"><?=CurrencyFormat($item["PRICE"]*$item['QUANTITY'], "RUB");?></div>
									</div>
								</div>
                                <? endforeach; ?>
                            <? endif; ?>

							<div class="orders-summ__total">Итого: <span></span><?=CurrencyFormat($totalBasketSum, "RUB");?></div>
						</div>
					</div>

					<? if (!empty($order['SHIPMENT'])): ?>
					<div class="orders-delivery">
						<div class="order-summup-header">Доставка</div>
						<? foreach ($order['SHIPMENT'] as $shipment): ?>

							<div class="order-delivery-header">
								Отгрузка
								№<?=htmlspecialcharsbx($shipment['ACCOUNT_NUMBER'])?>
                                <? if ($shipment['FORMATED_DELIVERY_PRICE']): ?>
									, <span>Стоимость доставки <?=$shipment['FORMATED_DELIVERY_PRICE']?></span>
                                <? endif; ?>
                                <? if ($shipment['DEDUCTED'] == 'Y'): ?>
									<span class="delivery-status__mark mark-grey">Отгружено</span>
                                <? else: ?>
									<span class="delivery-status__mark mark-red">Не отгружено</span>
                                <? endif; ?>
							</div>
							<div class="orders-delivery-status">Статус отправки: <span class="delivery-status__mark mark-grey"><?=htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME'])?></span></div>


		                    <?
		                    if (!empty($shipment['DELIVERY_ID'])): ?>
			                    <div class="orders-delivery-status">Служба доставки: <span><?=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?></span></div>
							<? endif; ?>

		                    <? if(!empty($shipment['ADDRESS'])): ?>
								<div class="orders-delivery-status">Адрес доставки: <span><?=$shipment['ADDRESS']?></span></div>
							<? endif; ?>

		                    <? if(!empty($shipment['TIME'])): ?>
								<div class="orders-delivery-status">Время доставки: <span><?=$shipment['TIME']?></span></div>
							<? endif; ?>

		                    <? if (!empty($shipment['TRACKING_NUMBER'])): ?>
								<div class="orders-delivery-status">Идентификатор отправления: <span><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span></div>
							<? endif; ?>
		                    <? if (strlen($shipment['TRACKING_URL']) > 0): ?>

		                    <? endif; ?>
						<? endforeach; ?>
					</div>
					<? endif; ?>

					<div class="orders-payments">
						<div class="order-summup-header">Оплата</div>
						<? foreach ($order['PAYMENT'] as $payment):
                            if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                    "order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                                    "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                    "allow_inner" => $arParams['ALLOW_INNER'],
                                    "refresh_prices" => $arParams['REFRESH_PRICES'],
                                    "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                    "only_inner_full" => $arParams['ONLY_INNER_FULL']
                                );
                            }
							?>

                        <? endforeach; ?>
						<div class="order-delivery-header">
                            <?
                            $paymentSubTitle = "Счёт №".
                                htmlspecialcharsbx('С-' . explode('/' , $payment['ACCOUNT_NUMBER'])[0]);
                            if(isset($payment['DATE_BILL']))
                            {
                                $paymentSubTitle .= " от ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
                            }
                            $paymentSubTitle .=",";
                            echo $paymentSubTitle;
                            ?>
							, <?=$payment['PAY_SYSTEM_NAME']?>
                            <?
                            if ($payment['PAID'] === 'Y'): ?>
	                            <span class="delivery-status__mark mark-grey"><?=Loc::getMessage('SPOL_TPL_PAID')?></span>
                            <? elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N'): ?>
								<span class="delivery-status__mark mark-grey"><?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?></span>
                            <? else: ?>
								<span class="delivery-status__mark mark-red">Не оплачено</span>
                            <? endif; ?>
						</div>
                        <?
                        $orderId = $order['ORDER']['ID'];
                        $paymentOrderId = $payment['ORDER_ID'];
                        if ($payment['PAY_SYSTEM_ID'] == 3):?>
	                        <div class="orders-delivery-status">
		                        Сумма оплаты по счету: <?= $payment['FORMATED_SUM'] ?>
	                        </div>
	                        <div class="orders-delivery-down">
		                        <a href="/personal/order/payment/?ORDER_ID=<?= $orderId ?>&pdf=1&DOWNLOAD=Y">Скачать счет</a>
	                        </div>
                        <? elseif ($payment['PAY_SYSTEM_ID'] == 6):?>
                            <?if ($payment['PAID'] != 'Y'):
                                $orderObj = \Bitrix\Sale\Order::load($orderId);
                                $paymentCollection = $orderObj->getPaymentCollection();
                                $onePayment = $paymentCollection[0];
                                $service = \Bitrix\Sale\PaySystem\Manager::getObjectById($onePayment->getPaymentSystemId());
                                $context = \Bitrix\Main\Application::getInstance()->getContext();
                                $service->initiatePay($onePayment, $context->getRequest());
                            endif;?>
                        <? endif; ?>

                        <? if (!empty($payment['CHECK_DATA'])):
                            $listCheckLinks = "";
                            foreach ($payment['CHECK_DATA'] as $checkInfo) {
                                $title = Loc::getMessage('SPOL_CHECK_NUM',
                                        ['#CHECK_NUMBER#' => $checkInfo['ID']]) . " - " . htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                                if (strlen($checkInfo['LINK'])) {
                                    $link = $checkInfo['LINK'];
                                    $listCheckLinks .= "<a href='$link' target='_blank'>$title</a>";
                                }
                            }
                            if (strlen($listCheckLinks) > 0):
                                ?>
	                            <div class="orders-delivery-status">
                                    <?= Loc::getMessage('SPOL_CHECK_TITLE') ?>:
                                    <?= $listCheckLinks ?>
	                            </div>
                            <?
                            endif;
                        endif;
                        ?>
					</div>
					<form method="GET" action="/personal/cart/">
						<input type="hidden" value="<?=$order['ORDER']['ID']?>" name="ID">
						<input type="hidden" value="Y" name="COPY">
						<input type="hidden" value="Y" name="EDIT">
						<button type="submit" class="item-buy__btn repeat-order">Повторить заказ</button>
					</form>
				</div>
            <?endforeach;?>
		</div>
    <?else:?>
		<div class="info-empty__content">
			<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
			<div class="info-empty__header">
				У вас пока нет заказов
			</div>
			<div class="info-empty__redirect">
				Перейдите в <a href="/katalog/" class="link-blue">Каталог</a> для оформления заказа
			</div>
		</div>
    <?endif?>

<?endif?>
