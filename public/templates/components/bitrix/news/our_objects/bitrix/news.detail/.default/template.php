<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?php ob_start() ?>
<!-- Objects detail popup -->
<div class="popup-layout object-popup__layout">
	<div class="popup object-detail-popup">
		<div class="popup-close">
			<img class="popup-close-icon" src="<?=SITE_TEMPLATE_PATH?>/img/close.svg">
		</div>
		<div class="popup-inner">
			<div class="object-img">
				<div class="object-slider">
					<div class="object-slide-big">
                        <? foreach ($arResult['SLIDER'] as $slideImage): ?>
							<div class="objects-slide-img__big">
								<img src="<?=$slideImage['SRC']?>">
							</div>
                        <? endforeach; ?>
					</div>
					<div class="object-slide-small">
                        <? foreach ($arResult['SLIDER'] as $slideImage): ?>
							<div class="objects-slide-img__small">
								<img src="<?=$slideImage['SRC']?>">
							</div>
                        <? endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$APPLICATION->AddViewContent('popups', ob_get_clean());
?>

<div class="objects-detail">
	<h1 class="page-header"><?=$arResult['NAME']?></h1>
	<div class="objects-detail__wrap">
		<div class="objects-detail__img">
            <? if (count($arResult['SLIDER']) > 0): ?>
	            <div class="detail-img__main">
		            <img src="<?=$arResult['SLIDER'][0]['SRC']?>">
	            </div>

	            <? if (count($arResult['SLIDER']) > 1): ?>
		            <div class="detail-img__add">
			            <div class="img-add__item">
				            <img src="<?=$arResult['SLIDER'][1]['SRC']?>">
			            </div>
	                    <? if (count($arResult['SLIDER']) > 2): ?>
				            <div class="img-add__item">
					            <img src="<?=$arResult['SLIDER'][2]['SRC']?>">
					            <div class="img-add__more"></div>
					            <span class="more-photos">+<?=count($arResult['SLIDER'])-1?></span>
				            </div>
	                    <? endif ?>
		            </div>
	            <? endif ?>
            <? else: ?>
	            <div class="detail-img__main">
		            <img src="/foto_not_found_510.jpg">
	            </div>
            <? endif ?>
		</div>

		<div class="object-detail__info">
            <? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
                <?= $arResult["DETAIL_TEXT"]; ?>
            <? else: ?>
                <?= $arResult["PREVIEW_TEXT"]; ?>
            <? endif ?>
		</div>
		<? if (count($arResult['CURRENT_REGION']['ITEMS'])): ?>
			<div class="more-objects">
				<div class="section-header">Еще объекты в "<?=$arResult['CURRENT_REGION']['NAME']?>"</div>
				<div class="more-objects-items">
					<? foreach ($arResult['CURRENT_REGION']['ITEMS'] as $arRegionItem):
                        $arPicture = CFile::ResizeImageGet(
                            $arRegionItem['PREVIEW_PICTURE'],
                            array(
                                'width' => 250,
                                'height' => 120
                            ),
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            false
                        );
						?>
						<div class="object-preview preview-in-detail">
							<img src="<?=$arPicture['src']?>" alt="<?=$arRegionItem['NAME']?>" class="object-preview__img">
							<div class="object-preview__text">
								<div class="object-preview__header">
									<?=$arRegionItem['NAME']?>
								</div>
								<div class="object-preview__name">
									<span>Объект:</span> <?=$arRegionItem['~PROPERTY_OBJECT_VALUE']?>
								</div>
								<div class="object-preview__task">
									<span>Задача:</span> <?=$arRegionItem['~PROPERTY_TASK_VALUE']?>
								</div>
							</div>
						</div>
					<? endforeach; ?>
				</div>
			</div>
        <? endif ?>
	</div>
</div>
