<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<script>
    gtag('event', 'page_view', {
        'send_to': 'AW-938852171',
        'ecomm_pagetype': 'purchase',
        'ecomm_prodid': <?=json_encode($arResult['ITEMS'])?>,
        'ecomm_totalvalue': '<?=$arResult['ORDER']['PRICE']?>'
    });
</script>
