<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?if(strlen($arResult["ERROR_MESSAGE"])<=0 && !$_REQUEST['canceled']):
    CModule::IncludeModule("main");
    CModule::IncludeModule("sale");

    $order = \Bitrix\Sale\Order::load($_REQUEST['ID']);
    if($order->getField('STATUS_ID') != 'N'){
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        if(!empty($arUser['UF_MANAGER'])){
            $rsManager = CUser::GetList($by="id", $order="asc", array('XML_ID' => $arUser['UF_MANAGER']), array('SELECT' => array('UF_ADDNUM')));
            $arManager = $rsManager->Fetch();
        }?>
        <p class="paragraph">К сожалению, заказ в настоящий момент не может быть отменен через сайт. Обратитесь, пожалуйста, к вашему менеджеру<?=$arManager ? (':<br> '.$arManager['LAST_NAME']. ' '.$arManager['NAME'] .' '. $arManager['SECOND_NAME']. ', тел. ' .$arManager['PERSONAL_PHONE']) : '.'?></p>
    <?} else {?>
        <form method="post" action="/personal/cancel_order.php">
            <input type="hidden" name="CANCEL" value="Y">
            <?=bitrix_sessid_post()?>
            <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
            <input type="hidden" name="action" value="Отменить заказ">
            <input type="hidden" name="canceled" value="1">

	        <p class="paragraph">Вы уверены, что хотите отменить заказ #<?=$arResult["ACCOUNT_NUMBER"]?>?</p>

	        <div class="form-login__btns" style="margin-bottom: 0">
		        <button type="submit" name="action" class="login-btn register-btn active-btn js-form-submit-cancel-order">Отменить заказ</button>
	        </div>
        </form>
    <?}?>
<?elseif (strlen($arResult["ERROR_MESSAGE"])<=0 && $_REQUEST['canceled']):?>
    <p>Заказ отменен</p>
<?else: ?>
    <p><?=ShowError($arResult["ERROR_MESSAGE"]);?></p>
<?endif;?>
