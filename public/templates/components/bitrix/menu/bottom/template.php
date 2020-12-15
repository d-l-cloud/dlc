<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?php if (!empty($arResult)): ?>

    <?php
    $arChunks = array_chunk($arResult, ceil(count($arResult) / 3));
    foreach ($arChunks as $arChunk): ?>
		<div class="footer-col">
			<div class="footer-col__list">
                <?php foreach ($arChunk as $arItem):
                    $arClasses = ['footer-info__item'];
                    if ($arItem['PARAMS']['IS_MOBILE_LINK']) {
                        $arClasses[] = 'footer-video-link';
                    }
	                ?>
					<p class="col-list__item">
						<a class="<?= implode(' ', $arClasses) ?>" href="<?= $arItem["LINK"] ?>">
                            <?= $arItem["TEXT"] ?>
						</a>
					</p>
                <?php endforeach; ?>
			</div>
		</div>
    <?php endforeach;
endif;