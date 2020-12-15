<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?php if (!empty($arResult)): ?>
    <?php foreach ($arResult as $arItem): ?>
		<div class="header-menu__item">
            <?php if (!empty($arItem['CHILDRENS'])): ?>
				<span class="selection-menu">
	                <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
	            </span>

				<div class="menu-item__list">
                    <?php foreach ($arItem['CHILDRENS'] as $arChildrenItem): ?>
						<div class="item-list__select"
						     href="<?= $arChildrenItem["LINK"] ?>">
							<a href="<?= $arChildrenItem["LINK"] ?>">
								<?= $arChildrenItem["TEXT"] ?>
							</a>
						</div>
                    <?php endforeach; ?>
				</div>
            <?php else: ?>
				<a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
            <?php endif; ?>
		</div>
    <?php endforeach ?>
<?php endif ?>