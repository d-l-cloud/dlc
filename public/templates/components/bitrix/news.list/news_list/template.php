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

<?if(count($arResult["ITEMS"])):?>
	<section>
		<div class="news">
			<h2 class="slider-header">Последние новости</h2>
			<div class="last-news">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
	            <a class="last-news__item" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                    <?php if(!empty($arItem["PREVIEW_PICTURE_RESIZED_SRC"])): ?>
		            <div class="news-item__img">
			            <img src="<?= $arItem["PREVIEW_PICTURE_RESIZED_SRC"] ?>">
		            </div>
                    <?endif?>
		            <div class="news-item__header">
                        <?= $arItem["~NAME"] ?>
		            </div>
		            <div class="news-item__description">
                        <?= $arItem["PREVIEW_TEXT"] ?>
		            </div>
	            </a>
            <?endforeach?>
			</a>
		</div>
	</section>
<?endif?>