<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = ["CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')];
?>

<section class="main-catalog__header">
    <?
    $h1 = $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'];
    if (!$h1) {
        $h1 = $arResult['SECTION']['NAME'];
    }

    if ($h1):
        $APPLICATION->SetPageProperty('title', $arResult['SECTION']['NAME']); ?>
		<h1 class="page-header"><?= $h1 ?></h1>
    <?php else:
        if ($arParams["IBLOCK_TYPE"] === "cat") {
            $APPLICATION->SetPageProperty('title', 'Каталог');
        }
    endif; ?>
    <?
    $view_subs = 1;
    if (isset($arParams['FROM_ROOT']) && $arParams['FROM_ROOT'] == 1) {
        $view_subs = 0;
    }
    if ($view_subs && 0 < $arResult["SECTIONS_COUNT"]): ?>
		<div class="categories-slide">
            <? foreach ($arResult['SECTIONS'] as &$arSection):
                if (false === $arSection['PICTURE']) {
                    $arSection['PICTURE'] = [
                        'SRC' => $this->GetFolder() . '/images/tile-empty.png',
                        'ALT' => (
                        '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                            ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                            : $arSection["NAME"]
                        ),
                        'TITLE' => (
                        '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                            ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                            : $arSection["NAME"]
                        )
                    ];
                }
                ?>
				<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" class="categories-slide__item">
					<div class="content-item__block categories-slide__item">
						<div class="tab-block__img categories-slide__img">
							<img src="<?= $arSection['PICTURE']['SRC']; ?>">
						</div>
						<div class="tab-block__info categories-slide__info">
							<div class="block-info__name categories-slide__name"><?= $arSection['NAME']; ?></div>
                            <?php if ($arSection['ELEMENT_CNT'] > 0): ?>
								<div class="tab-info__goods">
                                    <?= $arSection['ELEMENT_CNT'] . ' ' . wordCountEndings($arSection['ELEMENT_CNT'],
                                        'товар', 'товара', 'товаров') ?>
								</div>
                            <?php else: ?>
								<div class="tab-info__goods no-goods">Товаров нет</div>
                            <?php endif; ?>
						</div>
					</div>
				</a>
            <? endforeach;
            unset($arSection);
            ?>
		</div>
    <? endif; ?>
</section>