<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?php if ($arResult["SECTIONS_COUNT"] > 0): ?>
	<div class="cataloglist-mobile">
	<?php foreach ($arResult['SECTIONS'] as $key => $arSection): ?>
		<div class="cataloglist-item">
			<a class="cataloglist-item__elem" href="<?= $arSection['SECTION_PAGE_URL'] ?>">
                <?= $arSection['NAME'] ?>
			</a>
		</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>