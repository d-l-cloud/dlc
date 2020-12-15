<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>



<? if (!empty($arResult['ERRORS']['FATAL'])): ?>

    <? foreach ($arResult['ERRORS']['FATAL'] as $error): ?>
        <?= ShowError($error) ?>
    <? endforeach ?>

<? else: ?>

    <? if (!empty($arResult['ERRORS']['NONFATAL'])): ?>

        <? foreach ($arResult['ERRORS']['NONFATAL'] as $error): ?>
            <?= ShowError($error) ?>
        <? endforeach ?>

    <? endif ?>

    <? if (!empty($arResult['ITEMS'])): ?>
		<div class="my-purchases">
            <? foreach ($arResult['ITEMS'] as $arSection): ?>
				<div class="purchases-block">
					<div class="purchases-header"><?=$arSection['NAME']?></div>
					<div class="purchases-row">
						<div class="purchases-col purchase-col__header">Товар</div>
						<div class="purchases-col purchase-col__header">Цена</div>
						<div class="purchases-col purchase-col__header">Динамика цены</div>
					</div>

					<? foreach($arSection['ITEMS'] as $item): ?>
						<div class="purchases-row">
							<div class="purchases-col">
                                <?=isset($item['PAGE']) ? '<a href="'.$item['PAGE']. '">'. $item['NAME']. '</a>' : $item['NAME']?>
								<br/>
								<span class="order-articul">Артикул <?=$item['ART']?></span>
							</div>
							<div class="purchases-col purchases-price"><?=isset($item['PAGE']) ? CurrencyFormat($item['CURR_PRICE'], $item['CURRENCY']) : CurrencyFormat($item['PRICE'], $item['CURRENCY'])?></div>

                            <?$diffPrices = $item['CURR_PRICE'] - $item['PRICE']?>
							<div class="purchases-col <?=($diffPrices > 0) ? 'purchases-price__decrease' : 'purchases-price__growth'?>"><?=round($diffPrices * 100 / $item['PRICE'], 1)?>%</div>
						</div>
                    <? endforeach ?>
				</div>
            <? endforeach ?>
		</div>
    <? else: ?>
		<div class="info-empty__content">
			<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/buy.svg" alt="" class="lk-empty__img">
			<div class="info-empty__header">
				У вас пока нет покупок
			</div>
			<div class="info-empty__redirect">
				Перейдите в <a href="/katalog/" class="link-blue">Каталог</a> для оформления заказа
			</div>
		</div>
    <? endif ?>
<? endif ?>
	