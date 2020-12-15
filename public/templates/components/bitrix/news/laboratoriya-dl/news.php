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

<? $this->SetViewTarget('filter_by_year'); ?>
<?
$from_year = '';
$arSelect = ["DATE_CREATE"];
$arFilter = ["IBLOCK_ID" => IntVal($arParams['IBLOCK_ID']), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"];
$res = CIBlockElement::GetList(["DATE_CREATE" => "ASC"], $arFilter, false, ["nTopCount" => 1], ["DATE_CREATE"]);
if ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $from_year = intval(date('Y', strtotime($arFields['DATE_CREATE'])));
}

$to_year = '';
$arSelect = ["DATE_CREATE"];
$arFilter = ["IBLOCK_ID" => IntVal($arParams['IBLOCK_ID']), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"];
$res = CIBlockElement::GetList(["DATE_CREATE" => "DESC"], $arFilter, false, ["nTopCount" => 1], ["DATE_CREATE"]);
if ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $to_year = intval(date('Y', strtotime($arFields['DATE_CREATE'])));
}
$currentYear = $to_year;
$curr_year = 'Все';
if ($to_year):
    if (isset($_GET['year']) && intval($_GET['year'])) {
        $curr_year = trim($_GET['year']);
    } ?>
	<div class="news-sort">
		<div class="features news-sort-tabs">
			<a href="<?=$APPLICATION->GetCurPage()?>"
			   class="features-item <?= ($curr_year == 'Все') ? 'features-active' : '' ?>">
				Все
			</a>
            <? do { ?>
				<a href="?year=<?= $to_year ?>"
				   class="features-item <?= ($curr_year == $to_year) ? 'features-active' : '' ?>">
                    <?= $to_year ?>
				</a>
            <? } while (--$to_year >= $from_year); ?>
		</div>
	</div>
<? endif;

global $arFilter;
if (is_numeric($curr_year)) {
    $arFilter = [
        ">=DATE_CREATE" => '01.01.' . $curr_year,
        "<DATE_CREATE" => '01.01.' . ($curr_year + 1),
    ];
} else {
    $arFilter = [
        "<DATE_CREATE" => '01.01.' . ($currentYear + 1)
    ];
}

$this->EndViewTarget();?>


<article>
	<div class="documents">
		<h1 class="page-header"><? $APPLICATION->ShowTitle(false); ?></h1>


		<div class="documents-wrap">
			<div class="documents-text">
				<p class="paragraph">
					Уважаемые партнеры, мы начинаем новую рубрику на нашем сайте – «Лаборатория «ДОРЛОК»», в которой мы будем разбирать претензии, рекламации, курьезные случаи, связанные с поставляемой нами продукцией.
				</p>
				<p class="paragraph">
					В этой рубрике мы постараемся проанализировать основные ошибки при монтаже, классические случаи неисправностей, типичные и нетипичные примеры брака продукции от наших и других поставщиков.
				</p>
				<p class="paragraph">
					Целью введения этого раздела на наш сайт является помощь вам, нашим партнерам, в поиске путей решения возникающих трудностей, связанных с дверными или оконными комплектующими, в их профилактике, и в обучение вашего персонала методике «купирования» проблем на их ранней стадии.
				</p>
			</div>
		</div>

		<?
		$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"laboratoriya-dl",
			Array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"NEWS_COUNT" => $arParams["NEWS_COUNT"],

				"SORT_BY1" => $arParams["SORT_BY1"],
				"SORT_ORDER1" => $arParams["SORT_ORDER1"],
				"SORT_BY2" => $arParams["SORT_BY2"],
				"SORT_ORDER2" => $arParams["SORT_ORDER2"],

				//"FILTER_NAME" => $arParams["FILTER_NAME"],
				"FILTER_NAME" => 'arFilter',
				"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"CHECK_DATES" => $arParams["CHECK_DATES"],
				"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
				"SEARCH_PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"],

				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

				"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
				"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"SET_BROWSER_TITLE" => "Y",
				"SET_META_KEYWORDS" => "Y",
				"SET_META_DESCRIPTION" => "Y",
				"MESSAGE_404" => $arParams["MESSAGE_404"],
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"SHOW_404" => $arParams["SHOW_404"],
				"FILE_404" => $arParams["FILE_404"],
				"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
				"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],

				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "Y",

				"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
				"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
				"MEDIA_PROPERTY" => $arParams["MEDIA_PROPERTY"],
				"SLIDER_PROPERTY" => $arParams["SLIDER_PROPERTY"],

				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
				"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
				"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
				"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
				"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
				"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

				"USE_RATING" => $arParams["USE_RATING"],
				"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
				"MAX_VOTE" => $arParams["MAX_VOTE"],
				"VOTE_NAMES" => $arParams["VOTE_NAMES"],

				"USE_SHARE" => $arParams["LIST_USE_SHARE"],
				"SHARE_HIDE" => $arParams["SHARE_HIDE"],
				"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
				"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
				"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
				"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],

				"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
			),
			$component
		);?>
	</div>
</article>
