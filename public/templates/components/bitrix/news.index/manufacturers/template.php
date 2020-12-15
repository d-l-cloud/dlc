<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>


<section class="brands-list">
    <?php foreach ($arResult['IBLOCKS'] as $arIBlock):
        foreach ($arIBlock['ITEMS'] as $arItem): ?>
            <div class="brandlist-item">
	            <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>/">
		            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="" class="brandlist-item__img">
	            </a>
            </div>
        <?php endforeach;
    endforeach; ?>
</section>
