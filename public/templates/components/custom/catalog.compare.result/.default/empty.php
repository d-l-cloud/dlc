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

<article>
    <div class="compare">
        <div class=" lk-info__empty">
            <div class="info-empty__content" style="padding-top: 1%">
                <img src="<?= SITE_TEMPLATE_PATH ?>/img/lk/order.svg" alt="" class="lk-empty__img">
                <div class="info-empty__header">
                    Список сравнения пуст
                </div>
                <div class="info-empty__redirect">
                    Вы ещё не добавили товары в сравнение
                </div>
            </div>
        </div>
    </div>
</article>