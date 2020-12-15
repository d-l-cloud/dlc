<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
    $APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}

?>
<div id="bx-soa-order-confirm" data-order_id="<?=$arResult["ORDER"]["ID"];?>">
<? if (!empty($arResult["ORDER"])): ?>
	<article>
		<div class="order-completed">
			<div class="order-completed-inner">
				<img class="order-completed-img" src="<?=SITE_TEMPLATE_PATH?>/img/fileboard-checked.svg" alt="">
				<div class="singlepage-textblock">
					<p class="paragraph">
						Ваш заказ <span class="paragraph-bolder">№<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?></span> от <span class="paragraph-bolder"><?=$arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i')?></span> успешно создан.
                        <? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
	                        Номер вашей оплаты: <span class="paragraph-bolder">№<?=$arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']?></span>
                        <? endif ?>
					</p>
					<p class="paragraph">
						Вы можете следить за выполнением своего заказа в <a href="/personal/#orders" class="link-blue">Персональном разделе сайта</a>. Обратите внимание, что для входа в этот раздел вам необходимо будет ввести логин и пароль пользователя сайта.
					</p>

                    <? if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y'): ?>
                        <? if (!empty($arResult["PAYMENT"])):
				            foreach ($arResult["PAYMENT"] as $payment):
                                $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

				                if ($payment["PAID"] != 'Y'):
                                    $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                    $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                    $orderId = urlencode(urlencode($arResult["ORDER"]["ID"]));
                                    $paymentId = $payment["ORDER_ID"];
                                    ?>
					                <div class="order-completed-links">
                                        <? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
							                <a href="<?= $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderId . "&PAYMENT_ID=" . $paymentId ?>" class="link-blue">Оплата заказа</a>

	                                        <script>
                                                window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderId?>&PAYMENT_ID=<?=$paymentId?>');
	                                        </script>
	                                        <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
							                    <a href="<?= $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderId . "&pdf=1&DOWNLOAD=Y" ?>" class="link-blue">Скачать счет</a>
	                                        <? endif; ?>
                                        <? else: ?>
                                            <?=$arPaySystem["BUFFERED_OUTPUT"]?>
                                        <? endif ?>
					                </div>
					                <p class="paragraph">
                                        <? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
							                Если окно с платежной информацией не открылось автоматически, нажмите на ссылку Оплатить заказ.
	                                        <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
							                    Для того, чтобы скачать счет в формате pdf, нажмите на ссылку Скачать счет.
	                                        <? endif; ?>
                                        <? endif; ?>
					                </p>
                                <? endif; ?>
							<? endforeach; ?>
                        <? endif; ?>
					<? endif; ?>
				</div>
			</div>
		</div>
	</article>

<? else: ?>

    <b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
    <br /><br />

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
                <?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
            </td>
        </tr>
    </table>

<? endif ?>