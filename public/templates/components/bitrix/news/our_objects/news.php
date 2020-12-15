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

<div class="objects">
	<h2 class="page-header">Наши объекты</h2>
	<div class="objects-cols-wrap">
		<div class="objects-col js-map" style="position: relative">
			<div class="map-obj-hint" style="pointer-events: none">
				<div class="map-obj-area"></div>
				<a class="link-blue"></a>
			</div>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/include/objects-map.php' ?>
		</div>
		<div class="objects-col objects-col-right">
			<div class="objects-selection">
				<div class="objects-list">
					<div class="choose-dealer-wrap">
						<div class="region-filters__item">
							<span class="region-current js-objects-region-current">Все области</span>
							<span class="statick-tick"></span>
						</div>
						<div class="region-selector__list">
							<div class="region-selector__option js-objects-region-option" data-region="all">
								<div class="region-name">Все области</div>
							</div>
                            <?php
                            $arFilter = Array('IBLOCK_ID' => 15, 'GLOBAL_ACTIVE'=>'Y', array());
                            $db_list = CIBlockSection::GetList(Array(), $arFilter, true);
                            while($ar_result = $db_list->GetNext()) {
                                $arSelect = [
                                    "ID",
                                    "NAME",
                                    "DETAIL_PAGE_URL",
                                    "PREVIEW_PICTURE",
                                    "PROPERTY_OBJECT",
                                    "PROPERTY_TASK"
                                ];
                                $arFilter = [
                                    "IBLOCK_ID" => 15,
                                    "SECTION_ID" => $ar_result['ID'],
                                    "ACTIVE_DATE" => "Y",
                                    "ACTIVE" => "Y"
                                ];
                                $res = CIBlockElement::GetList(['sort' => 'asc'], $arFilter, false, [], $arSelect);

                                if ($res->SelectedRowsCount()) {
                                    $arRegions[$ar_result['ID']] = [
                                        'CODE' => $ar_result['CODE'],
                                        'NAME' => $ar_result['NAME'],
                                        'DESCRIPTION' => $ar_result['DESCRIPTION'],
                                        "ITEMS" => []
                                    ];
                                    while ($ob = $res->GetNextElement()) {
                                        array_push($arRegions[$ar_result['ID']]["ITEMS"], $ob->GetFields());
                                    }
                                    ?>
									<div class="region-selector__option js-objects-region-option" data-region="<?= $ar_result['CODE'] ?>">
										<div class="region-name"><?=$ar_result['NAME']?></div>
									</div>
                                    <?php
                                }
                            }
                            ?>
						</div>
					</div>

					<div class="choose-dealer-wrap">
						<div class="region-filters__item">
							<span class="region-current js-objects-address-current" data-region="all">Все объекты</span>
							<span class="statick-tick"></span>
						</div>
						<div class="region-selector__list">
							<div class="region-selector__option js-objects-address-option" data-object-id="all">
								<div class="region-name">Все объекты</div>
							</div>
                            <?php foreach($arRegions as $arRegion): ?>
                                <?php foreach($arRegion["ITEMS"] as $key => $arItem): ?>
									<div class="region-selector__option js-objects-address-option" data-region="<?=$arRegion['CODE']?>" data-object-id="<?=$arItem['ID']?>">
										<div class="region-name"><?=$arItem['NAME']?></div>
									</div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="object-right__wrap">
				<?php foreach($arRegions as $arRegion): ?>
                    <?php foreach($arRegion["ITEMS"] as $key => $arItem):
						$arPicture = CFile::ResizeImageGet(
                            $arItem['PREVIEW_PICTURE'],
                            array(
                                'width' => 250,
                                'height' => 120
                            ),
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            false
                        );
						?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="object-preview js-objects-address"
						   data-region="<?=$arRegion['CODE']?>" data-object-id="<?=$arItem['ID']?>">
							<img src="<?=$arPicture['src']?>" alt="<?=$arItem['NAME']?>" class="object-preview__img">
							<div class="object-preview__text">
								<div class="object-preview__header">
                                    <?=$arItem['NAME']?>
								</div>
								<div class="object-preview__name">
									<span>Объект:</span> <?=$arItem['~PROPERTY_OBJECT_VALUE']?>
								</div>
								<div class="object-preview__task">
									<span>Задача:</span> <?=$arItem['~PROPERTY_TASK_VALUE']?>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>