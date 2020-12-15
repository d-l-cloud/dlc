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
	<div class="lk-info__discount lk-info__inner">
		<div class="info-discount__row discount-totals">
			<div class="info-discount__col discount-totals__row">
				<div class="discount-col__header">
					Приобретено товаров на сумму
				</div>
				<div class="discount-col__num">
                    <?= $arResult['TOTAL_ORDER_SUM_FORMAT']; ?>
				</div>
			</div>
			<div class="info-discount__col discount-totals__row">
				<div class="discount-col__header">
					Ваша скидка
				</div>
				<div class="discount-col__num">
					<?= $arResult['CUR_DISCOUNT_FORMAT'] ?>
				</div>

			</div>
			<div class="info-discount__col discount-totals__row">
				<div class="discount-col__header">
					Необходимо для следующего уровня скидки
				</div>
				<div class="discount-col__num">
                    <?= $arResult['NEED_SUM'] ?>
				</div>

			</div>
		</div>
		<div class="info-discount__row scale-row">
			<div class="discount-grades">
				<div class="discount-grade__item grade-item__percent">5%</div>
				<div class="discount-grade__item grade-item__percent">10%</div>
				<div class="discount-grade__item grade-item__percent item-percent-last">15%</div>
			</div>
			<div class="scale">
				<div class="scale-fill" style="width: <?=$arResult['CUR_SCALE_PERCENT']?>%"></div>
			</div>
			<div class="discount-grades">
				<div class="discount-grade__item grade-item__purchases">100 000 руб</div>
				<div class="discount-grade__item grade-item__purchases">250 000 руб</div>
				<div class="discount-grade__item grade-item__purchases">500 000 руб</div>
			</div>
		</div>
	</div>
<?endif?>
	