<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Location;

Loc::loadMessages(__FILE__);

if ($arParams["UI_FILTER"]) {
	$arParams["USE_POPUP"] = true;
}
?>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>
	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?ShowError($error)?>
	<?endforeach?>
<?else:?>

	<div class="city-popup">
		<h2 class="popup-header">Ваш город</h2>

		<form class="city-popup__search js-sc-form" action="<?=$templateFolder . '/get.php'?>">
			<input type="hidden" name="select[1]" value="CODE">
			<input type="hidden" name="select[2]" value="TYPE_ID">
			<input type="hidden" name="select[VALUE]" value="ID">
			<input type="hidden" name="select[DISPLAY]" value="NAME.NAME">
			<input type="hidden" name="additionals[1]" value="PATH">

			<input type="hidden" name="filter[=NAME.LANGUAGE_ID]" value="<?=LANGUAGE_ID?>">
			<input type="hidden" name="filter[=SITE_ID]" value="<?=SITE_ID?>">

			<input type="hidden" name="version" value="2">
			<input type="hidden" name="PAGE_SIZE" value="5">
			<input type="hidden" name="PAGE" value="0">

			<input type="text"
			       class="city-search__input js-sc-input"
			       placeholder="Поиск...">
			<div class="search-img">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="7" cy="7" r="6" stroke="#828282" stroke-width="2"/>
					<path d="M14.2929 15.7071C14.6834 16.0976 15.3166 16.0976 15.7071 15.7071C16.0976 15.3166 16.0976 14.6834 15.7071 14.2929L14.2929 15.7071ZM15.7071 14.2929L11.7071 10.2929L10.2929 11.7071L14.2929 15.7071L15.7071 14.2929Z" fill="#828282"/>
				</svg>
			</div>
		</form>

		<div class="city-popup__popular">Популярные города</div>
		<div class="city-popup__variants js-sc-variants-main">
			<div class="city-variants__item js-sc-variant-item" data-name="Москва" data-code="0000073738">Москва</div>
			<div class="city-variants__item js-sc-variant-item" data-name="Санкт-Петербург" data-code="0000103664">Санкт-Петербург</div>
			<div class="city-variants__item js-sc-variant-item" data-name="Краснодар" data-code="0000386590">Краснодар</div>
			<div class="city-variants__item js-sc-variant-item" data-name="Екатеринбург" data-code="0000812044">Екатеринбург</div>
			<div class="city-variants__item js-sc-variant-item" data-name="Новосибирск" data-code="0000949228">Новосибирск</div>
		</div>
		<div class="city-popup__variants js-sc-variants-search" style="display: none"></div>


		<script type="text/html" data-template-id="bx-ui-sls-error">
			<div class="bx-ui-sls-error">
				<div></div>
				{{message}}
			</div>
		</script>

		<script type="text/html" data-template-id="bx-ui-sls-dropdown-item">
			<div class="dropdown-item bx-ui-sls-variant">
				<span class="dropdown-item-text">{{display_wrapped}}</span>
                <?if($arResult['ADMIN_MODE']):?>
					[{{id}}]
                <?endif?>
			</div>
		</script>

		<div class="bx-ui-sls-error-message">
            <?if(!$arParams['SUPPRESS_ERRORS']):?>
                <?if(!empty($arResult['ERRORS']['NONFATAL'])):?>
                    <?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
                        <?ShowError($error)?>
                    <?endforeach?>
                <?endif?>
            <?endif?>
		</div>
	</div>
<?endif?>