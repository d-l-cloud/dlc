<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<div class="pagination js-pagination">
	<? if ($arResult['NavPageCount'] > 1) { ?>
		<? if($arResult["bDescPageNumbering"] === true):
			$bFirst = true;
			if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
				if($arResult["bSavePage"]): ?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" page="<?=$arResult["NavPageNomer"]-1?>" class="prev"></a>
		        <? else:
					if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ): ?>
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" page="<?=$arResult["NavPageNomer"]-1?>" class="prev"></a>
		            <? else: ?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" page="<?=$arResult["NavPageNomer"]-1?>" class="prev"></a>
		            <? endif;
				endif;

				if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
					$bFirst = false;
					if($arResult["bSavePage"]): ?>
					<a class="forum-page-first"  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a>
		            <? else: ?>
					<a class="forum-page-first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
		            <? endif;
					if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)): ?>
					<div class="sep">...</div>
		            <? endif;
				endif;
			endif;
			do {
				$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

				if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
				<a class="active"><?=$NavRecordGroupPrint?></a>
		        <? elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false): ?>
				<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"
				   class="<?=($bFirst ? "forum-page-first" : "")?>"><?=$NavRecordGroupPrint?></a>
		        <? else: ?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"
				   class="<?=($bFirst ? "forum-page-first" : "")?>"><?=$NavRecordGroupPrint?></a>
		        <? endif;

				$arResult["nStartPage"]--;
				$bFirst = false;
			} while($arResult["nStartPage"] >= $arResult["nEndPage"]);

			if ($arResult["NavPageNomer"] > 1):
				if ($arResult["nEndPage"] > 1):
					if ($arResult["nEndPage"] > 2): ?>
				<div class="sep">...</div>
		            <? endif; ?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a>
		        <? endif; ?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="next"></a>
		    <? endif;

		else:
			$bFirst = true;

			if ($arResult["NavPageNomer"] > 1):
				if($arResult["bSavePage"]): ?>
					<a page="<?=$arResult["NavPageNomer"]-1?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="pagination-item-arrow back"></a>
		        <? else:
					if ($arResult["NavPageNomer"] > 2): ?>
						<a page="<?=$arResult["NavPageNomer"]-1?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="pagination-item-arrow back"></a>
		            <? else: ?>
						<a page="<?=$arResult["NavPageNomer"]-1?>" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pagination-item-arrow back"></a>
		            <? endif;

				endif;

				if ($arResult["nStartPage"] > 1):
					$bFirst = false;
					if($arResult["bSavePage"]): ?>
						<a page="1" class="pagination-item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
		            <? else: ?>
						<a page="1" class="pagination-item" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
		            <? endif;
					if ($arResult["nStartPage"] > 2): ?>
						<span class="sep">...</span>
		            <? endif;
				endif;
			endif;

			do {
				if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
					<a page="<?=$arResult["nStartPage"];?>" href="#" class="pagination-item active-pagination-item"><?=$arResult["nStartPage"]?></a>
		        <? elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false): ?>
					<?/*<a page="<?=$arResult["nStartPage"];?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>*/?>
					<a page="<?=$arResult["nStartPage"];?>" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pagination-item"><?=$arResult["nStartPage"]?></a>
		        <? else: ?>
					<a page="<?=$arResult["nStartPage"];?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="pagination-item"><?=$arResult["nStartPage"]?></a>
		        <? endif;
				$arResult["nStartPage"]++;
				$bFirst = false;
			} while($arResult["nStartPage"] <= $arResult["nEndPage"]);

			if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
				if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
				endif; ?>
				<a page="<?=$arResult["NavPageNomer"]+1?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="pagination-item-arrow"></a>
		    <? endif;
		endif;

		if ($arResult["bShowAll"]):
			if ($arResult["NavShowAll"]): ?>
				<!--<a class="forum-page-pagen" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></a>-->
		    <? else: ?>
				<!--<a class="forum-page-all" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></a>-->
		    <? endif;
		endif; ?>
	<? } ?>
</div>
