<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
//die();

$ids = array_keys($arResult['GRID']['ROWS']);
if(empty($ids)){
    $ids = [];
}
?>

<script>
    gtag('event', 'page_view', {
        'send_to': 'AW-938852171',
        'ecomm_pagetype': 'cart',
        'ecomm_prodid': <?=json_encode($ids);?>,
        'ecomm_totalvalue': '<?=$arResult['allSum'];?>'
    });
</script>


<div style="display: none;" class="for_search">
<?
print_r($arResult["GRID"]["ROWS"]);
print_r($arResult);

?>
</div>