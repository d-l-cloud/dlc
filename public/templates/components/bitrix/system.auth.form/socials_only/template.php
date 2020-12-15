<?if
    (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    CJSCore::Init();
?>

<?
    if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
    ShowMessage($arResult['ERROR_MESSAGE']);
?>

<?if($arResult["FORM_TYPE"] == "login"):?>
    <form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
        <?if($arResult["BACKURL"] <> ''):?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>

        <?foreach ($arResult["POST"] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>

        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="AUTH" />

	    <div class="socials-header">
		    Войти через социальные сети
	    </div>
	    <div class="popup-socials">
        <?php if($arResult["AUTH_SERVICES"]):?>
            <?
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
                array(
                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                    "SUFFIX"=>"form",
                ),
                $component,
                array("HIDE_ICONS"=>"Y")
            );
            ?>
        <?endif?>
	    </div>
    </form>

    <?if($arResult["AUTH_SERVICES"]):?>
        <?
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                array(
                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                    "AUTH_URL"=>$arResult["AUTH_URL"],
                    "POST"=>$arResult["POST"],
                    "POPUP"=>"Y",
                    "SUFFIX"=>"form",
                ),
                $component,
                array("HIDE_ICONS"=>"Y")
            );
        ?>
    <?endif?>
<?endif?>