<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<?foreach($arParams["~AUTH_SERVICES"] as $service):?>
	<a class="popup-socials__item" href="javascript:void(0)" onclick="BxShowAuthFloat('<?=$service["ID"]?>', '<?=$arParams["SUFFIX"]?>')">
		<img src="<?= SITE_TEMPLATE_PATH ?>/img/<?=$service["ID"]?>.svg" alt="">
	</a>
<?endforeach?>
