<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?php if ($arResult["SECTIONS_COUNT"] > 0): ?>
<div class="catalog-tabs tabs-switcher">
	<!--<a class="catalog-tabs__item" href="/automatic_doors/" style="display: block">Автоматические двери</a>-->
    <?php
    $isFirstSI = true;
    ?>
	<?php foreach ($arResult['SECTIONS'] as $key => $arSection): ?>
		<div class="catalog-tabs__item <?=($isFirstSI) ? 'active-tab' : ''?>"><?= $arSection["NAME"] ?></div>
        <?php
        $isFirstSI = false;
        ?>
	<?php endforeach; ?>
	<div class="catalog-tabs__item">Бренды</div>
</div>
<div class="catalog-content tabs-content">
	<!-- Автоматические двери -->
	<!--<div class="tab-content__item content-item">

	</div>-->
	<?php
		$isFirstST = true;
	?>
    <?php foreach ($arResult['SECTIONS'] as $key => $arSection): ?>
	    <div class="tab-content__item content-item <?=($isFirstST) ? 'active-tab__content' : ''?>">
		    <?php if (count($arSection['CHILDREN']) > 0):
			    $arChildrenChunks = array_chunk($arSection['CHILDREN'], 2);
			    ?>
		        <?php foreach ($arChildrenChunks as $arChunk): ?>
					<div class="content-block__wrap">
			            <?php foreach ($arChunk as $arChildrenSection): ?>
				            <a class="content-item__block" href="<?= $arChildrenSection['SECTION_PAGE_URL']; ?>">
					            <div class="tab-block__img">
						            <img src="<?= $arChildrenSection['PICTURE']['SRC'] ?>" alt="">
					            </div>
					            <div class="tab-block__info">
						            <div class="block-info__name"><?= $arChildrenSection["NAME"] ?></div>
						            <?php if ($arChildrenSection['ELEMENT_CNT'] > 0): ?>
							            <div class="tab-info__goods">
								            <?= $arChildrenSection['ELEMENT_CNT'] . ' ' . wordCountEndings($arChildrenSection['ELEMENT_CNT'], 'товар', 'товара', 'товаров') ?>
							            </div>
                                    <?php else: ?>
							            <div class="tab-info__goods no-goods">Товаров нет</div>
                                    <?php endif; ?>
					            </div>
				            </a>
			            <?php endforeach; ?>
					</div>
                <?php endforeach; ?>
            <?php endif; ?>
	    </div>
	    <?php
        $isFirstST = false;
	    ?>
    <?php endforeach; ?>

	<!-- Бренды -->
	<div class="tab-content__item content-item">
		<?php $APPLICATION->IncludeComponent(
		    'bitrix:news.index',
		    'manufacturers_menu',
		    [
		        'CACHE_GROUPS' => 'Y',
		        'CACHE_TIME'   => 36000000,
		        'CACHE_TYPE'   => 'A',
		        'FIELD_CODE'   => ['PREVIEW_PICTURE'],
		        'IBLOCKS'      => [3],
		        'NEWS_COUNT'   => '100',
		        'DETAIL_URL'   => '/manufacturers/#ID#',
		    ]
		); ?>
	</div>
</div>
<?php endif; ?>