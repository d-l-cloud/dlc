<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>


<?php foreach ($arResult["MESSAGE"] as $itemID => $itemValue): ?>
	<script>
        $(document).ready(function() {
            openSubscribePopup(true);
        });
	</script>
    <?php
    break;
endforeach;


foreach ($arResult["ERROR"] as $itemID => $itemValue): ?>
	<script>
        $(document).ready(function() {
            openSubscribePopup(false);
        });
	</script>
    <?php
    break;
endforeach;

if ($arResult["ID"] == 0 && empty($_REQUEST["action"]) || CSubscription::IsAuthorized($arResult["ID"])) {
    include("setting.php");
}