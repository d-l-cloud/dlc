<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<?php foreach ($arResult['IBLOCKS'] as $arIBlock):
    if (count($arIBlock['ITEMS']) > 0):
        $arItemsChunk = array_chunk($arIBlock['ITEMS'], 2); ?>
        <?php foreach ($arItemsChunk as $arChunk): ?>
		<div class="content-block__wrap">
            <?php foreach ($arChunk as $arItem): ?>
	            <a class="content-item__block" href="<?= $arItem['DETAIL_PAGE_URL'] ?>/">
		            <div class="tab-block__img">
			            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="">
		            </div>
		            <div class="tab-block__info">
			            <div class="block-info__name"><?= $arItem["NAME"] ?></div>
                        <?php if ($arItem['ELEMENT_CNT'] > 0): ?>
				            <div class="tab-info__goods">
                                <?= $arItem['ELEMENT_CNT'] . ' ' . wordCountEndings($arItem['ELEMENT_CNT'], 'товар', 'товара', 'товаров') ?>
				            </div>
                        <?php else: ?>
				            <div class="tab-info__goods no-goods">Товаров нет</div>
                        <?php endif; ?>
		            </div>
	            </a>
            <?php endforeach; ?>
		</div>
        <?php endforeach; ?>
    <?php endif;
endforeach; ?>
