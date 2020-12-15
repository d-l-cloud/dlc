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

echo '<pre>';
//var_dump($arResult["ITEMS"]);
echo '</pre>';

?>

<div class="glossary">
<? if (count($arResult["ITEMS"])): ?>
	<h1 class="page-header">
        <? $APPLICATION->ShowTitle(false)?>
	</h1>
	<div class="glossary-search">
		<input type="text" class="glossary-search__input search__input js-glossary-search" placeholder="Поиск..." data-url="<?=$APPLICATION->GetCurPage()?>">
		<div class="search-img">
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="7" cy="7" r="6" stroke="#828282" stroke-width="2"></circle>
				<path d="M14.2929 15.7071C14.6834 16.0976 15.3166 16.0976 15.7071 15.7071C16.0976 15.3166 16.0976 14.6834 15.7071 14.2929L14.2929 15.7071ZM15.7071 14.2929L11.7071 10.2929L10.2929 11.7071L14.2929 15.7071L15.7071 14.2929Z" fill="#828282"></path>
			</svg>
		</div>
	</div>

    <? $APPLICATION->ShowViewContent('filter_by_section'); ?>

	<div class="js-glossary-content">
		<div class="glossary-wrap">
			<div class="glossary-content">
				<? foreach ($arResult['SECTIONS'] as $section): ?>
					<div class="glossary-item">
						<div class="glossary-item__header"><?=$section['NAME']?></div>
	                    <? foreach ($section['ITEMS'] as $arItem): ?>
		                    <p class="paragraph"><span class="paragraph-bolder"><?=$arItem['NAME']?></span> – <?=$arItem['PREVIEW_TEXT']?></p>
	                    <? endforeach; ?>
					</div>
				<? endforeach; ?>
			</div>
			<section>
	            <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	                <?= $arResult["NAV_STRING"] ?>
	            <? endif; ?>
			</section>
		</div>
	</div>
<? elseif (!empty(trim($_GET['q']))): ?>
	<div class="js-glossary-content">
		<div class=" lk-info__empty">
			<div class="info-empty__content" style="padding-top: 1%">
				<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
				<div class="info-empty__header">
					Ничего не найдено
				</div>
				<div class="info-empty__redirect">
					По данному запросу ничего не найдено
				</div>
			</div>
		</div>
	</div>
<? else: ?>
	<div class="lk-info__empty">
		<div class="info-empty__content" style="padding-top: 1%">
			<img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
			<div class="info-empty__header">
				Глоссарий пуст
			</div>
			<div class="info-empty__redirect">
				В данный момент в глоссарии определений нет записей
			</div>
		</div>
	</div>
<? endif; ?>
</div>