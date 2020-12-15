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

global $arEnabledFilters;
$arEnabledFilters = [];
?>

<div class="cat-col cat-col__left">
	<form class="sidebar sidebar-filter"
	      name="<?= $arResult["FILTER_NAME"]."_form" ?>"
	      action="<?= $arResult["FORM_ACTION"] ?>"
	      method="get">
        <?php foreach($arResult["HIDDEN"] as $arItem): ?>
			<input type="hidden" name="<?= $arItem["CONTROL_NAME"] ?>"
			       id="<?= $arItem["CONTROL_ID"] ?>"
			       value="<?= $arItem["HTML_VALUE"] ?>" />
        <?php endforeach; ?>

        <?php foreach ($arResult["ITEMS"] as $key => $arItem): //prices
            $key = $arItem["ENCODED_ID"];
            if (isset($arItem["PRICE"])):
                if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
                    continue;
                }

                $step_num = 3;
                $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                $prices = [];
                if (Bitrix\Main\Loader::includeModule("currency")) {
                    for ($i = 0; $i < $step_num; $i++) {
                        $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i,
                            $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                    }
                    $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"],
                        $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                } else {
                    $precision = 0;
                    for ($i = 0; $i < $step_num; $i++) {
                        $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision, ".",
                            "");
                    }
                    $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                }

                if (empty($arItem["VALUES"]["MIN"]["HTML_VALUE"])) {
                    $arItem["VALUES"]["MIN"]["HTML_VALUE"] = $arItem["VALUES"]["MIN"]["VALUE"];
                }

                if (empty($arItem["VALUES"]["MAX"]["HTML_VALUE"])) {
                    $arItem["VALUES"]["MAX"]["HTML_VALUE"] = $arItem["VALUES"]["MAX"]["VALUE"];
                }

                if ($arItem["VALUES"]["MIN"]["VALUE"] != $arItem["VALUES"]["MIN"]["HTML_VALUE"]) {
                    $arEnabledFilters[] = [
                        'INPUT_ID' => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                        'LABEL' => 'Цена от ' . $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                        'SET_VALUE' => $arItem["VALUES"]["MIN"]["VALUE"],
                    ];
                }

                if ($arItem["VALUES"]["MAX"]["VALUE"] != $arItem["VALUES"]["MAX"]["HTML_VALUE"]) {
                    $arEnabledFilters[] = [
                        'INPUT_ID' => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                        'LABEL' => 'Цена до ' . $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                        'SET_VALUE' => $arItem["VALUES"]["MAX"]["VALUE"],
                    ];
                }
                ?>
	            <div class="filter-block filter-range">
		            <div class="filter-header">Цена, руб</div>
		            <span class="tick"></span>
		            <div class="filter-hidden range-wrap js-catalog-range"
		                 data-min-value="<?= intval($arItem["VALUES"]["MIN"]["VALUE"]) ?>"
		                 data-max-value="<?= intval($arItem["VALUES"]["MAX"]["VALUE"]) ?>"
		                 data-cur-min-value="<?= intval($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ?>"
		                 data-cur-max-value="<?= intval($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ?>">
			            <div class="js-catalog-slider"></div>
			            <div class="double-input">
				            <input type="text"
				                   class="cost-input js-catalog-range-min"
				                   name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
				                   id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
				                   value="<?= intval($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ?>"
				                   onkeyup="smartFilter.keyup(this)"/>
				            <input type="text"
				                   class="cost-input js-catalog-range-max"
				                   name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
				                   id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
				                   value="<?= intval($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ?>"
				                   onkeyup="smartFilter.keyup(this)"/>
			            </div>
		            </div>
	            </div>
            <?php endif; ?>
         <?php endforeach; ?>

        <?php foreach ($arResult["ITEMS"] as $key => $arItem): //color
            $key = $arItem["ENCODED_ID"];
            if ($arItem["IBLOCK_ID"] == 2 && $arItem["CODE"] == 'COLOR'):
                ?>
	            <div class="filter-block filter-colors">
		            <div class="filter-header"><?=$arItem["NAME"]?></div>
		            <span class="tick <?=($arItem["DISPLAY_EXPANDED"]== "Y") ? 'spin' : ''?>"></span>
		            <div class="filter-hidden color-wrap <?=($arItem["DISPLAY_EXPANDED"]== "Y") ? 'filter-visible' : ''?>">
                        <?php foreach ($arItem["VALUES"] as $val => $ar):
                            if ($ar["CHECKED"]) {
                                $arEnabledFilters[] = [
                                    'INPUT_ID' => $ar["CONTROL_ID"],
                                    'LABEL' => $ar["VALUE"],
                                    'COLOR_IMG' => 'background-image: url(' . $ar["XML_ID"] . ');',
                                ];
                            }
	                        ?>
				            <div class="filter-color__item">
					            <div class="checkbox-item">
						            <input class="custom-checkbox color-checkbox" type="checkbox"
						                   value="<?= $ar["HTML_VALUE"] ?>"
						                   name="<?= $ar["CONTROL_NAME"] ?>"
						                   id="<?= $ar["CONTROL_ID"] ?>" <?= $ar["CHECKED"]? 'checked="checked"': '' ?>
						                   onclick="smartFilter.click(this)">
						            <label class="checkbox-label color-checkbox__label" for="<?= $ar["CONTROL_ID"] ?>">
							            <span class="filter-color" style="background-image: url(<?=$ar['XML_ID']?>);"></span><?=$ar["VALUE"];?></label>
					            </div>
				            </div>
                        <?php endforeach; ?>
		            </div>
	            </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($arResult["ITEMS"] as $key => $arItem): //not prices
            if (count($arItem["VALUES"]) <= 1 || isset($arItem["PRICE"])) {
                continue;
            }

            if ($arItem["IBLOCK_ID"] == 2 && $arItem["CODE"] == 'COLOR') {
            	continue;
            }

            if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)) {
                continue;
            }
            ?>

	        <div class="filter-block">
		        <div class="filter-header"><?=$arItem["NAME"]?></div>
		        <span class="tick <?=($arItem["DISPLAY_EXPANDED"]== "Y") ? 'spin' : ''?>"></span>
		        <?php
                $arCur = current($arItem["VALUES"]);

                switch ($arItem["DISPLAY_TYPE"]) {
	                case 'A': ?>
		                <div class="filter-hidden range-wrap js-catalog-range <?=($arItem["DISPLAY_EXPANDED"]== "Y") ? 'filter-visible' : ''?>">
			                <div class="double-input">
				                <input type="text"
				                       class="cost-input"
				                       name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
				                       id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
				                       value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
				                       onkeyup="smartFilter.keyup(this)"/>
				                <input type="text" class="cost-input"
				                       name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
				                       id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
				                       value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
				                       onkeyup="smartFilter.keyup(this)"/>
			                </div>
		                </div>
	                	<? break;
                    case "B": //NUMBERS ?>
	                    <?php break;
	                case "G": //CHECKBOXES_WITH_PICTURES ?>
	                    <?php break;
	                case "H": //CHECKBOXES_WITH_PICTURES_AND_LABELS ?>
	                    <?php break;
	                case "P": //DROPDOWN ?>
	                    <?php break;
	                case "R": //DROPDOWN_WITH_PICTURES_AND_LABELS ?>
	                    <?php break;
	                case "K": //RADIO_BUTTONS ?>
	                    <?php break;
	                case "U": //CALENDAR ?>
	                    <?php break;
	                default: ?>
		                <div class="filter-hidden range-wrap <?=($arItem["DISPLAY_EXPANDED"]== "Y") ? 'filter-visible' : ''?>">
			                <?php if (count($arItem["VALUES"]) > 5): ?>
				                <div class="filter-search">
					                <input class="input-filter__search js-catalog-filter-search"
					                       data-prop-id="<?= $arItem['ID'] ?>"
					                       placeholder="Поиск..." type="search">
					                <label for="" class="search-label">
						                <img src="<?=SITE_TEMPLATE_PATH?>/img/catalog/search.svg" class="search-icon">
					                </label>
				                </div>
			                <?php endif; ?>
                            <?php foreach($arItem["VALUES"] as $val => $ar):
                                if ($ar["CHECKED"]) {
                                    $arEnabledFilters[] = [
                                        'INPUT_ID' => $ar["CONTROL_ID"],
                                        'LABEL' => $ar["VALUE"],
                                    ];
                                } ?>
				                <div class="checkbox-item js-catalog-filter-value"
				                     data-prop-id="<?= $arItem['ID'] ?>"
				                     data-prop-value="<?=$ar["VALUE"];?>">
					                <input class="custom-checkbox " type="checkbox"
					                       value="<?= $ar["HTML_VALUE"] ?>"
					                       name="<?= $ar["CONTROL_NAME"] ?>"
					                       id="<?= $ar["CONTROL_ID"] ?>" <?= $ar["CHECKED"]? 'checked="checked"': '' ?>
					                       onclick="smartFilter.click(this)">
					                <label class="checkbox-label" for="<?= $ar["CONTROL_ID"] ?>"><?=$ar["VALUE"];?></label>
				                </div>
                            <?php endforeach; ?>
		                </div>
                <?php } ?>
	        </div>
        <?php endforeach; ?>
	</form>
</div>

<script type="text/javascript">
    var smartFilter;
	$(document).ready(function () {
		smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
    });
</script>