<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php $this->SetViewTarget('complect_block'); ?>
    <?php if(!empty($arResult['CATEGORIES'])): ?>
		<div class="components">
			<div class="components-col pick-city-col">
				<p class="components-header components-col__left">Комплектующие для</p>
			</div>
			<div class="components-col components-col__items">
	            <?php foreach($arResult['CATEGORIES'] as $category): ?>
					<div class="components-item">
                        <?php if(!empty($category['PICTURE'])): ?>
	                        <img src="<?= CFile::GetPath($category['UF_IMAGE']); ?>">
                        <?php endif; ?>
						<p><?= $category['NAME'] ?></p>

                            <?php if(!empty($category['CHILDREN'])): ?>
                                <div class="components-item__hover">
		                            <?php $arChildrenChunk = array_chunk($category['CHILDREN'], ceil(count($category['CHILDREN']) / 3));
	                                foreach($arChildrenChunk as $arChunk): ?>
										<div class="item-hover__col">
											<?php foreach($arChunk as $arChildren): ?>
												<div class="item-hover__items">
													<a href="/katalog/filter/complect-is-<?= $arChildren['CODE'] ?>/apply/">
	                                                    <?= $arChildren['NAME'] ?>
													</a>
												</div>
	                                        <?php endforeach; ?>
										</div>
	                                <?php endforeach; ?>
								</div>
                            <?php endif; ?>

					</div>
	            <?php endforeach; ?>
			</div>
		</div>
    <?endif?>
<?$this->EndViewTarget();?>